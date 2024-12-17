<?php

use App\Models\Setting;
use Carbon\Carbon;
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

if (!function_exists('setting')) {
    function setting($key, $default = '')
    {
        $item = Setting::where('key', $key)->first();
        return $item ? $item->value : $default ?? '';
    }
}

if (!function_exists('format_datetime')) {
    function format_datetime($dateTime)
    {
        $newDate = Carbon::parse($dateTime);
        return $newDate->format('Y-m-d H:i:s');
    }
}