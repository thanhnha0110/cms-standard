<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SubMenuItem extends Component
{
    public $link;
    public $text;
    public $activeClass;

    public function __construct($link, $text, $activeClass = '')
    {
        $this->link = $link;
        $this->text = $text;
        $this->activeClass = $activeClass;
    }

    public function render()
    {
        return view('components.sub-menu-item');
    }
}