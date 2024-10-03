<?php
namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $label;
    public $type;
    public $isDisabled;

    public function __construct($label, $type = 'button', $isDisabled = false)
    {
        $this->label = $label;
        $this->type = $type;
        $this->isDisabled = $isDisabled;
    }

    public function render()
    {
        return view('components.button');
    }
}