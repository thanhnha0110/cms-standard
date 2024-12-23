<?php

namespace App\View\Components;

use App\Enums\StatusEnum;
use Illuminate\View\Component;

class Status extends Component
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
        $status = StatusEnum::tryFrom($this->status);
        return $status ? $status->getClass() : 'm-badge--default';
    }

    public function getText()
    {
        $status = StatusEnum::tryFrom($this->status);
        return $status ? $status->getText() : 'Unknown';
    }
}