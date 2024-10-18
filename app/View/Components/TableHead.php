<?php
namespace App\View\Components;

use Illuminate\View\Component;

class TableHead extends Component
{
    public $permissions;

    public function __construct($permissions = null)
    {
        $this->permissions = $permissions;
    }

    public function render()
    {
        return view('components.table-head');
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