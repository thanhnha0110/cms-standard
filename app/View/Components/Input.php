<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $label;
    public $type;
    public $id;
    public $name;
    public $value;
    public $error;
    public $required;
    public $attributes;

    public function __construct($label = '', $type = 'text', $id = '', $name = '', $value = '', $error = '', $required = '', $attributes = '')
    {
        $this->label = $label;
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->error = $error;
        $this->required = $required;
        $this->attributes = $attributes;
    }

    public function render()
    {
        return view('components.input');
    }
}