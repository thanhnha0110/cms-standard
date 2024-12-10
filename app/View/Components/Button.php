<?php
namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $label;
    public $type;
    public $isDisabled;
    public $class;
    public $attributes;

    public function __construct($label, $type = 'button', $class = '', $isDisabled = false, $attributes = '')
    {
        $this->label = $label;
        $this->type = $type;
        $this->class = $class;
        $this->isDisabled = $isDisabled;
        $this->attributes = $attributes;
    }

    public function render()
    {
        return view('components.button');
    }
}