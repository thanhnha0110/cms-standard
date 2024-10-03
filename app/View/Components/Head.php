<?php
namespace App\View\Components;

use Illuminate\View\Component;

class Head extends Component
{
    public $title;

    public function __construct($title = 'Default Title')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('includes.head', ['title' => $this->title]);
    }
}