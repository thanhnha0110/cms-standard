<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CMS language setting
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */
    'login' => 'Login',
    'menus' => [
        'dashboard' => 'Dashboard',
        'settings' => 'Settings',
        'platform_administration' => 'Platform Administrator',
        'management' => 'Management',
    ],
    'users' => [
        'title' => 'Users',
        'form' => [
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
            'password' => 'Password',
            'password_confirmation' => 'Password Confirmation',
        ],
    ],
    'roles_and_permissions' => [
        'title' => 'Roles and Permissions',
        'form' => [
            'name' => 'Name',
        ],
    ],
    'dashboard' => [
        'title' => 'Dashboard',
    ],
    'logs' => [
        'title' => 'Activities Logs',
    ],
    'settings' => [
        'general' => [
            'title' => 'General',
            'form' => [
                'information' => 'General Information',
                'appearance' => 'Admin appearance',
                'company_name' => 'Company name',
                'company_email' => 'Company email',
                'company_phone' => 'Company phone',
                'company_tax' => 'Company tax',
                'company_fax' => 'Company fax',
                'company_address' => 'Company address',
                'timezone' => 'Timezone',
                'site_language' => 'Site language',
                'admin_title' => 'Admin title',
                'admin_logo' => 'Admin logo',
                'admin_favicon' => 'Admin favicon',
            ],
        ],
        'email' => [
            'title' => 'Email',
        ],
        'api' => [
            'title' => 'API Settings',
        ],
    ],
    'categories' => [
        'title' => 'Categories',
        'form' => [
            'name' => 'Name',
            'icon' => 'Icon',
            'type' => 'Type',
        ],
    ],
];