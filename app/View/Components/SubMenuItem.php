<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SubMenuItem extends Component
{
    public $link;
    public $text;

    public function __construct($link, $text)
    {
        $this->link = $link;
        $this->text = $text;
    }

    public function render()
    {
        return view('components.sub-menu-item');
    }
}