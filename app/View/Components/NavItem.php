<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavItem extends Component
{
    public $link;
    public $text;
    public $icon;

    public function __construct($link = 'javascript:void;', $text, $icon)
    {
        $this->link = $link;
        $this->text = $text;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.nav-item');
    }
}