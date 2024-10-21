<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
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
        return view('system.roles.index', compact(
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
        return view('system.roles.create', compact('title'));
    }

    /**
     * Store
     */
    public function store(RoleRequest $request)
    {
        try {
            $role = $this->roleRepository->create($request->all());
            $this->permissionRepository->syncByRole($role, $request->permissions);
            return redirect()->route('system.roles.index')->with('success', trans('notices.create_success_message'));
        } catch (Exception $e) {
            return redirect()->route('system.roles.create')->with('error', $e->getMessage());
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
        return view('system.roles.edit', compact(
            'title',
            'item',
        ));
    }

    /**
     * Update
     */
    public function update(RoleRequest $request, $id)
    {
        try {
            $item = $this->roleRepository->findOrFail($id);
            $this->roleRepository->update($item, $request->all());
            $this->permissionRepository->syncByRole($item, $request->permissions);
            return redirect()->route('system.roles.edit', $id)->with('success', trans('notices.update_success_message'));
        } catch (Exception $e) {
            return redirect()->route('system.roles.edit', $id)->with('error', $e->getMessage());
        }
    }
}