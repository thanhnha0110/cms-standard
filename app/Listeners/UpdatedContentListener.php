<?php

namespace App\Listeners;

use App\Enums\LogActionEnum;

class UpdatedContentListener extends BaseContentListener
{
    public function handle($event)
    {
        parent::store($event, LogActionEnum::UPDATED);
    }
}