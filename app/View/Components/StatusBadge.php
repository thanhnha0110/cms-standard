<?php

namespace App\View\Components;

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
        return match ($this->status) {
            'active' => 'm-badge--success',
            'inactive' => 'm-badge--warning',
            'cancelled' => 'm-badge--danger',
            default => 'm-badge--default',
        };
    }

    public function getText()
    {
        return match ($this->status) {
            'active' => 'Active',
            'inactive' => 'Inactive',
            'cancelled' => 'Cancelled',
            default => 'Unknown',
        };
    }
}