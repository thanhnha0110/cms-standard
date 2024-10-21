<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public $method;
    public $action;
    public $submitLabel;
    public $cancelLabel;
    public $cancelUrl;

    public function __construct($method, $action, $submitLabel = 'Save', $cancelLabel = 'Cancel', $cancelUrl = null)
    {
        $this->method = $method;
        $this->action = $action;
        $this->submitLabel = $submitLabel;
        $this->cancelLabel = $cancelLabel;
        $this->cancelUrl = $cancelUrl ?? url()->previous();
    }

    public function render()
    {
        return view('components.form');
    }
}