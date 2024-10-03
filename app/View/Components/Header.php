<?php
namespace App\View\Components;

use Illuminate\View\Component;

class Header extends Component
{
    public $title;

    public function __construct($title = 'Default Title')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('includes.header', ['title' => $this->title]);
    }
}