<?php

namespace App\Listeners;

use App\Events\DeletedContentEvent;
use App\Models\ActivityLog;

class DeletedContentListener
{
    public function handle(DeletedContentEvent $event)
    {
        $log = ActivityLog::create([
            'user_id' => auth()->user()->id,
            'module' => $event->screen,
            'action' => 'deleted',
            'user_agent' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
        ]);
        $log->reference()->associate($event->model);
        $log->save();
    }
}