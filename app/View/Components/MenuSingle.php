<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuSingle extends Component
{
    public $link;
    public $text;
    public $iconClass;
    public $activeClass;
    public $permissions;

    public function __construct($link, $text, $iconClass, $activeClass = '', $permissions = null)
    {
        $this->link = $link;
        $this->text = $text;
        $this->iconClass = $iconClass;
        $this->activeClass = $activeClass;
        $this->permissions = is_array($permissions) ? $permissions : [$permissions];
    }

    public function render()
    {
        return view('components.menu-single');
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