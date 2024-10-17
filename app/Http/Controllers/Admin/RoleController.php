<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Exception;

class RoleController extends Controller
{
    public $title;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * CardController constructor.
     */
    public function __construct(
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository,
    ) {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;

        $this->title = trans('general.roles_and_permissions.title');
    }


    /**
     * Get and paginate all users
     */
    public function index(Request $request)
    {
        $title = $this->title;
        $page = $request->page;
        $size = $request->size;
        $search = $request->search;
        $items = $this->roleRepository->serverPaginationFilteringFor($request);
        return view('roles.index', compact(
            'title',
            'page',
            'size',
            'search',
            'items',
        ));
    }

    /**
     * Create
     */
    public function create()
    {
        $title = $this->title;
        return view('roles.create', compact('title'));
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        try {
            $role = $this->roleRepository->create($request->all());
            $per = $this->permissionRepository->createManyByRole($role, $request->permissions);
            
            return redirect()->route('users.index')->with('success', trans('notices.create_success_message'));
        } catch (Exception $e) {
            return redirect()->route('users.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Get and paginate all users
     */
    public function destroy($id)
    {
        try {
            $item = $this->roleRepository->findOrFail($id);
            $this->roleRepository->destroy($item);
            return $this->success(trans('notices.delete_success_message'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Get edit
     */
    public function edit($id)
    {
        $title = $this->title;
        $item = $this->roleRepository->findOrFail($id);
        return view('roles.edit', compact(
            'title',
            'item',
        ));
    }

    /**
     * Update
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $item = $this->roleRepository->findOrFail($id);
            $this->roleRepository->update($item, $request->all());
            return redirect()->route('users.edit', $id)->with('success', trans('notices.update_success_message'));
        } catch (Exception $e) {
            return redirect()->route('users.edit', $id)->with('error', $e->getMessage());
        }
    }
}