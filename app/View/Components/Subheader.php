<?php
namespace App\View\Components;

use Illuminate\View\Component;

class Subheader extends Component
{
    public $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('layouts.subheader');
    }
}