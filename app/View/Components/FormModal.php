<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormModal extends Component
{
    public $id;
    public $title;
    public $action;

    public function __construct($id, $title, $action)
    {
        $this->id = $id;
        $this->title = $title;
        $this->action = $action;
    }

    public function render()
    {
        return view('components.form-modal');
    }
}