<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $label;
    public $id;
    public $name;
    public $value;
    public $options;
    public $error;
    public $required;
    public $attributes;

    public function __construct($label, $id = '', $name = '', $value = '', $options = [], $error = '', $required = '', $attributes = '')
    {
        $this->label = $label;
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
        $this->error = $error;
        $this->required = $required;
        $this->attributes = $attributes;
    }

    public function render()
    {
        return view('components.select');
    }
}