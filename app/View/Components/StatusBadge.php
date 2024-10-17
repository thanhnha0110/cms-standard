<?php

namespace App\View\Components;

use App\Enums\UserStatusEnum;
use Illuminate\View\Component;

class StatusBadge extends Component
{
    public $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function render()
    {
        return view('components.status-badge');
    }

    public function getClass()
    {
        $status = UserStatusEnum::tryFrom($this->status);
        return $status ? $status->getClass() : 'm-badge--default';
    }

    public function getText()
    {
        $status = UserStatusEnum::tryFrom($this->status);
        return $status ? $status->getText() : 'Unknown';
    }
}