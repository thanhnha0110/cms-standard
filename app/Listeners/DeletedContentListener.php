<?php

namespace App\Listeners;

use App\Enums\LogActionEnum;

class DeletedContentListener extends BaseContentListener
{
    public function handle($event)
    {
        parent::store($event, LogActionEnum::DELETED);
    }
}