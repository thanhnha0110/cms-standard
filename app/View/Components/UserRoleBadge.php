<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class UserRoleBadge extends Component
{
    public $role;
    public $accentClass;
    public $roleText;

    public function __construct(int $role)
    {
        $this->role = $role;
        $this->accentClass = $this->getAccentClass();
        $this->roleText = $this->getRoleText();
    }

    public function render()
    {
        return view('components.user-role-badge');
    }

    public function getAccentClass()
    {
        return match ($this->role) {
            1 => 'm--font-danger',
            2 => 'm--font-primary',
            3 => 'm--font-accent',
            default => 'm--font-metal',
        };
    }

    public function getRoleText()
    {
        $role = Role::find($this->role);
        return $role ? $role->name : 'Unknown';
        return Role::find($this->role)->name;
    }
}