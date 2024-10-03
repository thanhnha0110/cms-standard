<?php

namespace App\Repositories\Eloquent;

use App\Models\UserToken;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\UserRepository;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use App\Models\Profile;
use App\Models\EmployeePosition;
use App\Models\RoleUser;
use App\Models\ProjectEmployee;
use App\Models\Project;
use App\Models\Workload;
use App\Models\Activation as ActivationModel;
use App\Models\Capacity;
use App\Models\User;
use App\Models\LeaveDate;
use App\Models\LeaveDateInfo;
use App\Models\Role;
use Carbon\Carbon;
use App\Models\Holiday;
use DateTime;
use DateInterval;
use App\Models\Department;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $model = $this->model->select('users.*')
            ->leftJoin('role_users', 'users.id', '=', 'role_users.user_id');

        if (!empty($request->get('search'))) {
            $term = $request->get('search');
            $model = $model->where(function ($query) use ($term) {
                $query->where('email', 'LIKE', "%{$term}%")
                    ->orWhere('first_name', 'LIKE', "%{$term}%")
                    ->orWhere('last_name', 'LIKE', "%{$term}%")
                    ->orWhere('users.id', $term);
            });
        }

        $filtered = false;
        $employeePositionQuery = EmployeePosition::query();

        if (isset($request->department_ids)) {
            $employeePositionQuery = $employeePositionQuery->whereIn('department_id', explode(',', $request->department_ids));

            if (!$filtered) {
                $filtered = true;
            }
        }

        if (isset($request->position_ids)) {
            $employeePositionQuery = $employeePositionQuery->whereIn('position_id', explode(',', $request->position_ids));

            if (!$filtered) {
                $filtered = true;
            }
        }

        if (isset($request->skillset_ids)) {
            $employeePositionQuery = $employeePositionQuery->whereIn('skillset_id', explode(',', $request->skillset_ids));

            if (!$filtered) {
                $filtered = true;
            }
        }

        if (isset($request->employee_role_ids)) {
            $employeePositionQuery = $employeePositionQuery->whereIn('employee_role_id', explode(',', $request->employee_role_ids));

            if (!$filtered) {
                $filtered = true;
            }
        }

        if (isset($request->level_ids)) {
            $employeePositionQuery = $employeePositionQuery->whereIn('level_id', explode(',', $request->level_ids));

            if (!$filtered) {
                $filtered = true;
            }
        }

        if ($filtered) {
            $userIds = $employeePositionQuery->pluck('user_id')->toArray();
            $model = $model->whereIn('users.id', $userIds);
        }

        if (isset($request->role_slugs)) {
            $roleIds = Role::whereIn('slug', explode(',', $request->role_slugs))->pluck('id')->toArray();
            $model->whereIn('role_users.role_id', $roleIds);
        }

        if (!empty($request->get('order_by')) && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'asc' ? 'asc' : 'desc';

            if ($request->order_by != 'seniority') {
                $model = $model->orderBy($request->get('order_by'), $order);
            } else {
                $model->join('profiles', 'profiles.user_id', '=', 'users.id')->select('users.*')->orderBy('profiles.on_boarding_date', $order);
            } 
        } else {
            $model = $model->orderBy('created_at', 'desc');
        }

        if (isset($request->status) && $request->status != 'all') {
            $userIds = ActivationModel::pluck('user_id')->toArray();

            if ($request->status) {
                $model = $model->whereIn('users.id', $userIds);
            } else {
                $model = $model->whereNotIn('users.id', $userIds);
            }
        }

        if (isset($request->is_remote) && $request->is_remote != 'all') {
            $userIds = Profile::where('is_remote', $request->is_remote)->pluck('user_id')->toArray();
            $model = $model->whereIn('users.id', $userIds);
        }

        if (is_employee()) {
            $model = $model->where('users.id', logged_user()->id);
        }

        $model = $model->paginate($request->get('per_page', 10));
        return $model;
    }

    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function getUsersByRoles(Request $request)
    {
        $model = $this->model->select('users.*')
            ->leftJoin('role_users', 'users.id', '=', 'role_users.user_id');

        if ($request->remove_current_user && $request->remove_current_user == 'true') {
            $model->where('users.id', '<>', $request->user()->id);
        }

        if (!empty($request->get('slug'))) {
            $roleId = get_role_id_by_slug($request->get('slug'));
            $model->where('role_users.role_id', $roleId);
        }
        return $model->get();
    }

    public function createUser($data)
    {
        try {
            DB::beginTransaction();

            //create users
            $this->hashPassword($data);
            $user = $this->model->create($data);
            //create role
            if (!empty($data['role_id'])) {
                $user->user_roles()->attach($data['role_id']);
            }
            //activations
            if ($data['is_activated'] == true) {
                $this->activateUser($user);
            }
            //creat user token
            $this->generateFor($user->id);

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Create User: ' . $e->getMessage());
            return null;
        }

    }

    public function updateUser($user, $data)
    {

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data["password"]);
        }

        //update users
        $user->update($data);

        //update role
        if (!empty($data['role_id'])) {
            $user->user_roles()->sync($data['role_id']);
        }
        //activations
        $this->checkForManualActivation($user, $data['is_activated']);

        return $user;
    }

    /**
     * Hash the password key
     * @param array $data
     */
    private function hashPassword(array &$data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
    }

    /**
     * Activate a user automatically
     *
     * @param $user
     */
    private function activateUser($user)
    {
        $activation = Activation::create($user);
        Activation::complete($user, $activation->code);
    }

    /**
     * Check and manually activate or remove activation for the user
     * @param $user
     * @param array $data
     */
    private function checkForManualActivation($user, $isActivated)
    {
        if (Activation::completed($user) && !$isActivated) {
            return Activation::remove($user);
        }

        if (!Activation::completed($user) && $isActivated) {
            $activation = Activation::create($user);
            return Activation::complete($user, $activation->code);
        }
    }

    /**
     * @param int $userId
     * @return \Modules\User\Entities\UserToken
     */
    public function generateFor($userId)
    {
        try {
            $uuid4 = Uuid::uuid4();
            $userToken = UserToken::create(['user_id' => $userId, 'access_token' => $uuid4]);
        } catch (\Exception $e) {
            $this->generateFor($userId);
        }

        return $userToken;
    }

    public function updateProfile($user, $data)
    {
        $this->hashPassword($data);
        unset($user->leave_dates);
        unset($user->employee_positions);
        unset($user->core_competencies);
        unset($user->projects);
        $user->update($data);
    }

    /**
     * Get users created at between time
     * @param $start
     * @param $end
     */
    public function getUsersByCreatedAt($start, $end)
    {
        return $this->model->whereBetween('created_at', [$start, $end])->get();
    }

    public function deleteUser($user) {
        if ($user->user_roles->first()->id == get_role_id_by_slug(config('core.roles.employee'))) {
            $condition = [
                'user_id' => $user->id
            ];

            Profile::where($condition)->delete();
            EmployeePosition::where($condition)->delete();
            RoleUser::where($condition)->delete();
            ProjectEmployee::where($condition)->delete();
            Workload::where($condition)->delete();
            Capacity::where($condition)->delete();
        }

        $this->model->where('id', $user->id)->delete();
    }

    public function getWorkloads(Request $request) {
        $model = $this->model;

        $query = Workload::whereBetween('date', [$request->from_date, $request->to_date])->where('time', '<>', 0);

        if (isset($request->type)) {
            $type = $request->type;

            if ($type == Workload::PLAN_TYPE_AS_PERCENTAGE) {
                $type = Workload::PLAN_TYPE;
            }

            if ($type == Workload::ACTUAL_TYPE_AS_PERCENTAGE) {
                $type = Workload::ACTUAL_TYPE;
            }

            $query = $query->where('type', $type);
        }

        if (!empty($request->project_ids)) {
            $query = $query->whereIn('project_id', explode(',', $request->project_ids));
        }

        if (!empty($request->user_ids)) {
            $query = $query->whereIn('user_id', explode(',', $request->user_ids));
        }

        $emptyUserIds = [];
        if (!empty($request->department_ids)) {
            $emptyUserIds = EmployeePosition::whereIn('department_id', explode(',', $request->department_ids))->pluck('user_id')->toArray();
            $query = $query->whereIn('user_id', $emptyUserIds);
        }

        $userIds = array_unique($query->pluck('user_id')->toArray());
        $emptyWorkloadUserQuery = Profile::whereNotIn('user_id', $userIds);

        if (!empty($request->project_ids)) {
            $projectUserIds = ProjectEmployee::whereIn('project_id', explode(',', $request->project_ids))->pluck('user_id')->toArray();
            $emptyWorkloadUserQuery = $emptyWorkloadUserQuery->whereIn('user_id', $projectUserIds);
        }

        if (!empty($request->user_ids)) {
            $emptyWorkloadUserQuery = $emptyWorkloadUserQuery->whereIn('user_id', explode(',', $request->user_ids));
        }

        if (!empty($request->department_ids)) {
            $emptyWorkloadUserQuery = $emptyWorkloadUserQuery->whereIn('user_id', $emptyUserIds);
        }

        $emptyWorkloadUserIds = $emptyWorkloadUserQuery->pluck('user_id')->toArray();
        $emptyWorkloadUsers = $model->whereIn('id', $emptyWorkloadUserIds)->get();
        $users = $model->whereIn('id', $userIds)->get();
        $originWorkloads = $query->get()->toArray();
        $workloads = $this->getUniqueWorkloads($originWorkloads);

        foreach ($users as $index => $user) {
            $users[$index]->capacity = $user->capacity->time ?? User::DEFAULT_CAPACITY;
            $userWorkloads = array_filter($workloads, function($workload) use ($user) {
                return $workload['user_id'] == $user->id;
            });
            $users[$index]->workloads = $userWorkloads;
            $users[$index]->project_tasks = $this->getProjectTasks($user->id, $originWorkloads);

            $conditions = [
                ['user_id', '=', $user->id],
                ['from', '>=', $request->from_date],
                ['to', '<=', $request->to_date]
            ];

            $users[$index]->leave_dates = LeaveDate::where($conditions)->get();
        }

        $users = $users->merge($emptyWorkloadUsers);
        
        return $users;
    }

    private function getUniqueWorkloads($workloads) {
        $uniqueWorkloads = [];

        foreach ($workloads as $index => $workload) {
            if (!isset($uniqueWorkloads[$workload['user_id'] . '-' . $workload['date']])) {
                $uniqueWorkloads[$workload['user_id'] . '-' . $workload['date']] = $workload;
            } else {
                $uniqueWorkloads[$workload['user_id'] . '-' . $workload['date']]['time'] += $workload['time'];
            }
        }

        return array_values($uniqueWorkloads);
    }

    public function getProjects($userId) {
        $projectIds = ProjectEmployee::where('user_id', $userId)->pluck('project_id')->toArray();
        $projects = Project::whereIn('id', $projectIds)->get();
        $workloads = Workload::where('user_id', $userId)->whereIn('project_id', $projectIds)->get();

        foreach ($projects as $index => $project) {
            $totalPlanTime = 0;
            $totalActualTime = 0;

            foreach ($workloads as $workloadIndex => $workload) {
                if ($workload->project_id == $project->id) {
                    if ($workload->type == Workload::PLAN_TYPE) {
                        $totalPlanTime += $workload->time;
                    } else {
                        $totalActualTime += $workload->time;
                    }
                }
            }

            $projects[$index]->total_plan_time = $totalPlanTime;
            $projects[$index]->total_actual_time = $totalActualTime;
        }

        return $projects;
    }

    public function find($userId) {
        $model = $this->model;

        $user = $model->find($userId);
        $user->leave_dates = $this->getLeaveDates($user->leave_dates);
        $user->employee_positions = $this->getEmployeePositions($user->employee_positions);
        $user->core_competencies = $this->getCoreCompetencies($user->core_competencies);
        $user->projects = $this->getCVProjects($user->projects);

        return $user;
    }

    private function getCVProjects($projects) {
        foreach ($projects as $index => $project) {
            $projects[$index]->technology_ids = array_map(function($technology) {
                return $technology['technology_id'];
            }, $projects[$index]->technologies->toArray());    

            $projects[$index]->cv_role_ids = array_map(function($cvRole) {
                return $cvRole['cv_role_id'];
            }, $projects[$index]->roles->toArray());  

            $projects[$index]->development_process_ids = array_map(function($developmentProcess) {
                return $developmentProcess['development_process_id'];
            }, $projects[$index]->development_processes->toArray()); 
        }

        return $projects;
    }

    private function getCoreCompetencies($coreCompetencies) {
        return array_map(function($coreCompetency) {
            return $coreCompetency['core_competency_id'];
        }, $coreCompetencies->toArray());
    }

    private function getEmployeePositions($userEmployeePositions) {
        $employeePositions = [];

        foreach ($userEmployeePositions as $userEmployeePosition) {
            $userEmployeePositionIndex = $userEmployeePosition->department_id . '-' . $userEmployeePosition->position_id . '-' . $userEmployeePosition->employee_role_id . '-' . $userEmployeePosition->level_id;
            if (empty($employeePositions[$userEmployeePositionIndex])) {
                $employeePositions[$userEmployeePositionIndex] = (object)[
                    'level_id' => $userEmployeePosition->level_id,
                    'department_id' => $userEmployeePosition->department_id,
                    'position_id' => $userEmployeePosition->position_id,
                    'employee_role_id' => $userEmployeePosition->employee_role_id,
                    'skillset_ids' => $userEmployeePosition->skillset_id ? [$userEmployeePosition->skillset_id] : [],
                    'disableSkillsetSelection' => false,
                    'disablePositionSelection' => false,
                    'resetOnOptionsChange' => false
                ];
            } else {
                if ($userEmployeePosition->skillset_id) {
                    $employeePositions[$userEmployeePositionIndex]->skillset_ids[] = $userEmployeePosition->skillset_id;
                }
            }
        }

        return array_values($employeePositions);
    }

    private function getLeaveDates($userLeaveDates) {
        $leaveDates = [];

        foreach ($userLeaveDates as $leaveDate) {
            $fromDate = strtotime($leaveDate->from);
            $toDate = strtotime($leaveDate->to);
            $dateDiff = $toDate - $fromDate;

            $leaveDate->number_of_days = round($dateDiff / (60 * 60 * 24)) + 1;
            $leaveDates[] = $leaveDate;
        }

        return $leaveDates;
    }

    private function getProjectTasks($userId, $workloads) {
        $projectTasks = [];

        foreach ($workloads as $workload) {
            if ($workload['user_id'] == $userId) {
                $projectTasks[] = (object)[
                    'code' => Project::find($workload['project_id'])->code,
                    'id' => $workload['id'],
                    'num_of_hours' => $workload['time'],
                    'date' => $workload['date'],
                    'name' => $workload['name'],
                    'jira_url' => $workload['jira_url']
                ];
            }
        }

        return array_values($projectTasks);
    }

    /**
     * Get leave dates of by year
     *
     * @param object $user
     * @param string|null $year
     */
    public function getLeaveDatesByYear($user, $year = null)
    {
        $year = $year && $year !== '' && $year !== 'null' ? $year : now()->year;
        return $user->leave_dates()->whereYear('from', $year)->get();
    }

    /**
     * Get leave dates of by year
     *
     * @param object $user
     * @return array
     */
    public function getDepartments($user) {
        $departments = [];

        foreach ($user->employee_positions as $key => $employeePosition) {
            $departmentName = Department::find($employeePosition->department_id)->name;
            if (!in_array($departmentName, $departments)) {
                $departments[] = $departmentName;
            }
        }

        return $departments;
    }

    /**
     * Get leave dates of by year
     *
     * @param object $user
     * @param string|null $year
     */
    public function getLeaveDateInfoByYear($user, $year = null)
    {
        $year = $year && $year !== '' && $year !== 'null' ? $year : now()->year;
        return LeaveDateInfo::where('user_id', $user->id)->where('year', $year)->first();
    }

    /**
     * Get leave dates of by year
     *
     * @param object $user
     * @param string|null $year
     */
    public function updateLeaveDateInfo($data)
    {
        unset($data['created_at']);
        unset($data['updated_at']);
        return LeaveDateInfo::where('user_id', $data['user_id'])->where('year', $data['year'])->update($data);
    }

    /**
     * Get bonus days by user's seniority
     *
     * @param object $user
     * @param string|null $year
     * @return int
     */
    public function getBonusDaysBySeniority($user, $year = null)
    {
        $year = $year && $year !== '' && $year !== 'null' ? $year : now()->year;
        $bonusDays = 0;
        if (isset($user->profile->on_boarding_date)) {
            $bonusDays = floor(getSeniority($user->profile->on_boarding_date, $year) / 3);
        }

        return $bonusDays;
    }

    /**
     * Get remaining days of user
     *
     * @param object $user
     * @param string|null $year
     * @return int
     */
    public function getRemaining($user, $year = null)
    {
        $year = $year && $year !== '' && $year !== 'null' ? $year : now()->year;
        $lastYear = $year - 1;
        $leaveDateInfo = LeaveDateInfo::where(['user_id'=> $user->id, 'year' => $lastYear])->first();
        $totalLeaveDates = $leaveDateInfo ? $leaveDateInfo->total : 0;
        $totalUsedDays = $user->leave_dates()->whereYear('from', $lastYear)->sum('number_of_days');

        $result = $totalLeaveDates - $totalUsedDays;
        if ($result < 0) {
            $result = 0;
        }
        if ($result > 6) {
            $result = 6;
        }

        return $result;
    }

    public function getWorkload(Request $request) {
        $data = [];

        $projects = ProjectEmployee::where('user_id', $request->user_id)->whereYear('created_at', $request->year)->get();
        $capacity = Capacity::DEFAULT_CAPACITY;
        $capacityObj = Capacity::where('user_id', $request->user_id)->latest()->first();

        if ($capacityObj) {
            $capacity = $capacityObj->time;
        }

        $startDate = date('Y-m-d', strtotime('first day of january this year'));
        $endDate = date('Y-m-d');

        if ($request->year != date('Y')) {
            $startDate = date('Y-m-d', mktime(0, 0, 0, 1, 1, $request->year));
            $endDate = $request->year . '-12-31';
        }

        $numOfWorkingDays = $this->getNumOfWorkingDays($startDate, $endDate);

        $data = [
            'num_of_projects' => $projects->count(),
            'num_of_capacity_hours' => $capacity * $numOfWorkingDays - ($capacity * $this->getNumOfLeaveDates($request->user_id, $startDate, $endDate)),
            'num_of_plan_hours' => $capacity * $numOfWorkingDays,
            'num_of_unassigned_hours' => $capacity * $numOfWorkingDays - ($capacity * $this->getNumOfWorkloads($request->user_id, $startDate, $endDate)),
            'workloads' => $this->getAnalysisWokloads($request->user_id, $startDate, $endDate)
        ];

        return $data;
    }

    /**
     * Get num of working day (Monday - Friday) between start date and to date
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    private function getNumOfWorkingDays($startDate, $endDate) {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);
        $numOfWorkingDays = 0;
        $holidays = $this->getHolidays($startDate, $endDate);

        while ($start <= $end) {
            $dayOfWeek = $start->format('N');
            $currentDate = $start->format('Y-m-d');
            if ($dayOfWeek < 6 && !in_array($currentDate, $holidays)) {
                $numOfWorkingDays++;
            }
            $start->add(new DateInterval('P1D'));
        }

        return $numOfWorkingDays;
    }

    /**
     * Get holiday dates between start date and end date
     *
     * @return array
     */
    private function getHolidays($startDate, $endDate) {
        $holidayData = Holiday::where('from_date', '>=', $startDate)->where('to_date', '<=', $endDate)->get();
        $holidays = [];

        foreach ($holidayData as $holidayItem) {
            $holidays = array_merge($holidays, $this->getDates($holidayItem->from_date, $holidayItem->to_date));
        }

        return $holidays;
    }

    /**
     * Get dates between start date and to date
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    private function getDates($startDate, $endDate) {
        $dates = [];
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        while ($startDate <= $endDate) {
            $dates[] = date('Y-m-d', $startDate);
            $startDate = strtotime('+1 day', $startDate);
        }

        return $dates;
    }

    /**
     * Get num of leave dates between start date and to date for user
     *
     * @param int $userId
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    private function getNumOfLeaveDates($userId, $startDate, $endDate) {
        $numOfLeaveDates = 0;
        $conditions = [
            ['user_id', '=', $userId],
            ['from', '>=', $startDate],
            ['to', '<=', $endDate]
        ];

        $leaveDates = LeaveDate::where($conditions)->get();
        $numOfLeaveDates = $leaveDates->sum('number_of_days');

        return $numOfLeaveDates;
    }

    /**
     * Get num of workloads between start date and to date for user
     *
     * @param int $userId
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    private function getNumOfWorkloads($userId, $startDate, $endDate) {
        $conditions = [
            ['user_id', '=', $userId],
            ['date', '>=', $startDate],
            ['date', '<=', $endDate],
            ['type', '=', Workload::PLAN_TYPE]
        ];
        $workloads = Workload::where($conditions)->get();

        return $workloads->count();
    }

    /**
     * Get workloads between start date and to date for user group by project
     *
     * @param int $userId
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    private function getAnalysisWokloads($userId, $startDate, $endDate) {
        $conditions = [
            ['user_id', '=', $userId],
            ['date', '>=', $startDate],
            ['date', '<=', $endDate],
        ];
        $workloads = [];
        $workloadData = Workload::where($conditions)->get();

        foreach ($workloadData as $key => $workloadItem) {
            if (empty($workloads[$workloadItem->project_id])) {
                $workloads[$workloadItem->project_id] = (object)[
                    'id' => $workloadItem->project_id,
                    'name' => $workloadItem->project->name,
                    'total_plan_workload' => $workloadItem->type == Workload::PLAN_TYPE ? $workloadItem->time : 0,
                    'total_actual_workload' => $workloadItem->type == Workload::ACTUAL_TYPE ? $workloadItem->time : 0
                ];
            } else {
                if ($workloadItem->type == Workload::PLAN_TYPE) {
                    $workloads[$workloadItem->project_id]->total_plan_workload += $workloadItem->time;
                } else {
                    $workloads[$workloadItem->project_id]->total_actual_workload += $workloadItem->time;
                }
            }
        }

        return array_values($workloads);
    }

    /**
     * Get leave dates of by year
     *
     * @param object $user
     * @param array $data
     */
    public function updateNumberOfDays($user, array $data)
    {
        foreach ($data as $item) {
            $condition = [
                'user_id' => $user->id,
                'from' => $item['from'],
                'to' => $item['to'],
            ];
            LeaveDate::where($condition)->update($item);
        }
        return true;
    }
}
