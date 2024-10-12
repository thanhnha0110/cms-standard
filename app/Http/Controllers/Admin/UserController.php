<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserController extends Controller
{
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
    }


    /**
     * Get and paginate all users
     */
    public function index(Request $request)
    {
        $title = trans('general.users.title');
        $items = $this->userRepository->serverPaginationFilteringFor($request);
        // dd($items->links());
        return view('users.index', ['title' =>$title, 'items' => $items]);
    }
}