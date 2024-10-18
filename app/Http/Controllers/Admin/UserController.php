<?php

namespace App\Http\Controllers\Admin;

use App\Events\DeletedContentEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Exception;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public $title;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * CardController constructor.
     */
    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->userRepository = $userRepository;

        $this->title = trans('general.users.title');
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
        $items = $this->userRepository->serverPaginationFilteringFor($request);
        return view('users.index', compact(
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
        $roles = Role::pluck('name', 'id')->toArray();
        return view('users.create', compact(
            'title',
            'roles'
        ));
    }

    /**
     * Store
     */
    public function store(UserRequest $request)
    {
        try {
            $this->userRepository->create($request->all());
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
            $item = $this->userRepository->findOrFail($id);
            $this->userRepository->destroy($item);
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
        $item = $this->userRepository->findOrFail($id);
        $roles = Role::pluck('name', 'id')->toArray();
        return view('users.edit', compact(
            'title',
            'item',
            'roles'
        ));
    }

    /**
     * Update
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $item = $this->userRepository->findOrFail($id);
            $this->userRepository->update($item, $request->all());

            event(new DeletedContentEvent(USER_MODULE_SCREEN_NAME, $request, $item));

            return redirect()->route('users.edit', $id)->with('success', trans('notices.update_success_message'));
        } catch (Exception $e) {
            return redirect()->route('users.edit', $id)->with('error', $e->getMessage());
        }
    }
}