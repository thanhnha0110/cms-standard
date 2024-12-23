<?php

namespace App\View\Components;

use App\Enums\UserStatusEnum;
use Illuminate\View\Component;

class Tags extends Component
{
    public $items;

    public function __construct($items = [])
    {
        $this->items = $items;
        
    }

    public function render()
    {
        return view('components.tags');
    }

}