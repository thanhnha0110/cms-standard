<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * AuthController constructor.
     */
    public function __construct(
        //
    ) {
        //
    }


    /**
     * View login
     *
     * @return void
     */
    public function getLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->route('get.login');
        }
    }

    /**
     * Login
     *
     * @param SignInRequest $request
     * @return void
     */
    public function postLogin(SignInRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                return redirect()->route('dashboard.index')->with('success', trans('notices.sign_in_success_message'));
            }
            return redirect()->route('get.login')->with('error', trans('notices.sign_in_fail_message'));
        } catch (Exception $e) {
            return redirect()->route('get.login')->with('error', $e->getMessage());
        }
    }
}