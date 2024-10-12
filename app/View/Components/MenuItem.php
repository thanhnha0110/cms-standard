<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuItem extends Component
{
    public $title;
    public $iconClass;
    public $activeClass;

    public function __construct($title, $iconClass, $activeClass = '')
    {
        $this->title = $title;
        $this->iconClass = $iconClass;
        $this->activeClass = $activeClass;
    }

    public function render()
    {
        return view('components.menu-item');
    }
}