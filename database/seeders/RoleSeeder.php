<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create permissions
        foreach (config('role_and_permission') as $roleHas => $role) {
            foreach ($role['permissions'] as $permission => $namePermission) {
                $namePermission = "{$roleHas}_{$permission}";
                Permission::updateOrCreate(['name' => $namePermission], ['name' => $namePermission]);
            }
        }

        // Create roles
        $list = [
            'Admin',
            'Manager',
            'Staff'
        ];

        foreach ($list as $item) {
            $newRole = Role::create(['name' => $item]);
            $newRole->syncPermissions(Permission::all());
        }

    }
}