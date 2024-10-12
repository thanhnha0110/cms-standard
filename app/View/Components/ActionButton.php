<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionButton extends Component
{
    public $icon;
    public $title;
    public $prefix;
    public $id;
    public $confirm;
    public $method;

    public function __construct(string $icon, string $title, string $prefix, int $id, bool $confirm = false, string $method = 'GET')
    {
        $this->icon = $icon;
        $this->title = $title;
        $this->prefix = $prefix;
        $this->id = $id;
        $this->confirm = $confirm;
        $this->method = $method;
    }

    public function render()
    {
        return view('components.action-button');
    }

    public function getUrl()
    {
        if ($this->method == 'DELETE') return 'javascript:void;';
        return route("{$this->prefix}.edit", $this->id);
    }
}