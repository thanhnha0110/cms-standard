<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('logged_user')) {
    function logged_user()
    {
        return Auth::check() ? Auth::user() : null;
    }
}

if (!function_exists('has_permission')) {
    /**
     * check user has permission
     *
     * @param string $permission
     * @return bool
     */
    function has_permission($permission)
    {
        $user = Auth::user();
        return $user && $user->can($permission);
    }
}