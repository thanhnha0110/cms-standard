<?php

namespace App\Listeners;

use App\Models\ActivityLog;

class BaseContentListener
{
    public function store($event, $action)
    {
        $log = ActivityLog::create([
            'user_id' => auth()->user()->id,
            'module' => $event->screen,
            'action' => $action,
            'user_agent' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
        ]);
        $log->reference()->associate($event->model);
        $log->save();
    }
}