<?php
namespace App\View\Components;

use Illuminate\View\Component;

class Subheader extends Component
{
    public $title;
    public $breadcrumbs;

    public function __construct($title = '', $breadcrumbs = [])
    {
        $this->title = $title;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function render()
    {
        return view('layouts.subheader');
    }
}