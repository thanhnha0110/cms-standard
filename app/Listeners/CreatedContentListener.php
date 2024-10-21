<?php

namespace App\Listeners;

use App\Enums\LogActionEnum;

class CreatedContentListener extends BaseContentListener
{
    public function handle($event)
    {
        parent::store($event, LogActionEnum::CREATED);
    }
}