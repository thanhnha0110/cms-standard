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
        'media' => 'Media',
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
                'shop_name' => 'Shop name',
                'company_name' => 'Company',
                'company_email' => 'Email',
                'company_phone' => 'Phone',
                'company_tax' => 'Tax',
                'company_fax' => 'Fax',
                'company_address' => 'Address',
                'company_country' => 'Country',
                'company_state' => 'State',
                'company_city' => 'City',
                'timezone' => 'Timezone',
                'site_language' => 'Site language',
                'admin_title' => 'Admin title',
                'admin_logo' => 'Admin logo',
                'admin_favicon' => 'Admin favicon',
            ],
        ],
        'email' => [
            'title' => 'Email',
            'form' => [
                'settings' => 'Settings',
                'mailer' => 'Mailer',
                'smtp' => [
                    'port' => 'Post',
                    'host' => 'Host',
                    'username' => 'Username',
                    'password' => 'Password',
                    'encryption' => 'Encryption',
                ],
                'ses' => [
                    'key' => 'Key',
                    'secret' => 'Secret',
                    'region' => 'Region',
                ],
                'sender_name' => 'Sender name',
                'sender_email' => 'Sender email',
                'send_test_mail_btn' => 'Send test mail',
                'send_test_mail_title' => 'Send a test mail',
                'send_test_mail_description' => 'To send test mail, please make sure you are updated configuration to send mail!',
                'send_test_mail_placeholder' => 'Enter the email which you want to send test mail.',
                'templates' => 'Email Templates',
                'subject' => 'Subject',
                'content' => 'Content',
            ],
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
    'media' => [
        'title' => 'Media',
        'form' => [
            'upload' => 'Upload',
            'create_folder' => 'Upload',
            'name' => 'Name',
            'full_url' => 'Full URL',
            'move_to_trash' => 'Move to trash',
            'rename' => 'Rename',
        ],
    ],
    'posts' => [
        'title' => 'Posts',
        'form' => [
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'featured_image' => 'Featured image',
            'focus_keywords' => 'Focus keywords',
            'status' => 'Status',
            'published_at' => 'Published at',
            'category' => 'Category',
            'tags' => 'Tags',
        ],
    ],
    'tags' => [
        'title' => 'Tags',
        'form' => [
            'name' => 'Name',
        ],
    ],
];