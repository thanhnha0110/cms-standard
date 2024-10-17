<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class EloquentPermissionRepository extends EloquentBaseRepository implements PermissionRepository
{
    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $search = $request->search;
        return $this->model->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->orderBy('id', 'desc')->paginate($request->size ?? 10);
    }


    /**
     * Paginating, ordering and searching through pages for server side index table
     * @param Request $request
     */
    public function createManyByRole($role, $permissions)
    {
        foreach ($permissions as $roleHas => $list) {
            foreach ($list as $permission) {
                $namePermission = $roleHas . '_' . $permission;
                $newPermission = $this->model->updateOrCreate(['name' => $namePermission], ['name' => $namePermission]);
                $role->givePermissionTo($newPermission);
            }
        }
    }
}