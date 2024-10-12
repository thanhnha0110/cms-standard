<?php
namespace App\View\Components;

use Illuminate\View\Component;

class Footer extends Component
{
    public $title;

    public function __construct($title = 'Default Title')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('layouts.footer', ['title' => $this->title]);
    }
}