<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $list = [
            [
                'title' => 'Welcome',
                'slug' => 'welcome',
                'subject' => 'Welcome to CMS',
                'description' => 'Send email to user when they register an account on our  site',
            ],
            [
                'title' => 'Confirm email',
                'slug' => 'confirm-email',
                'subject' => 'Confirm email',
                'description' => 'Send email to user when they register an account to verify their email',
            ],
            [
                'title' => 'Reset password',
                'slug' => 'reset-password',
                'subject' => 'Reset password',
                'description' => 'Send email to user when requesting reset password',
            ],
        ];

        foreach ($list as $item) {
            EmailTemplate::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}