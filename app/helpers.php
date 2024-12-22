<?php

use App\Models\Country;
use App\Models\MediaFile;
use App\Models\Setting;
use App\Models\Timezone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
        return Cache::rememberForever($key, function () use ($key, $default) {
            $item = Setting::where('key', $key)->first();
            return !empty($item->value) ? $item->value : $default ?? '';
        });
    }
}

if (!function_exists('format_datetime')) {
    function format_datetime($dateTime)
    {
        $newDate = Carbon::parse($dateTime);
        return $newDate->format('Y-m-d H:i:s');
    }
}

if (!function_exists('get_timezones')) {
    function get_timezones()
    {
        return Timezone::pluck('name', 'zone')->toArray();
    }
}

if (!function_exists('get_countries')) {
    function get_countries()
    {
        return Country::pluck('name', 'code')->toArray();
    }
}

if (!function_exists('get_media_files')) {
    function get_media_files()
    {
        return MediaFile::orderBy('id', 'desc')->paginate(10);
    }
}