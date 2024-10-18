<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SubMenuItem extends Component
{
    public $link;
    public $text;
    public $activeClass;
    public $permissions;

    public function __construct($link, $text, $activeClass = '', $permissions = null)
    {
        $this->link = $link;
        $this->text = $text;
        $this->activeClass = $activeClass;
        $this->permissions = $permissions;
    }

    public function render()
    {
        return view('components.sub-menu-item');
    }

    public function shouldRender()
    {
        if (is_null($this->permissions)) {
            return true;
        }

        foreach ($this->permissions as $permission) {
            if (has_permission($permission)) {
                return true;
            }
        }

        return false;
    }
}