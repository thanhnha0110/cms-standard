<?php

namespace App\Observers;

use App\Enums\UserStatusEnum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    public function creating(User $user)
    {
        $user->status = UserStatusEnum::ACTIVE;
        $user->password = $user->password ?? Hash::make(config('core.default.password'));
        $user->assignRole(intval($user->role_id));
    }

    public function updating(User $user)
    {
        $user->assignRole(intval($user->role_id));
    }
}