<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Exception;

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
        return view('users.edit', compact(
            'title',
            'item',
        ));
    }

    /**
     * Update
     */
    public function update($id, Request $request)
    {
        try {
            $item = $this->userRepository->findOrFail($id);
            $this->userRepository->update($item, $request->all());
            return redirect()->route('users.edit', $id)->with('success', trans('notices.update_success_message'));
        } catch (Exception $e) {
            return redirect()->route('users.edit', $id)->with('error', $e->getMessage());
        }
        
    }
}