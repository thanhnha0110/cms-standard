<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            [
                'first_name'=> 'Super',
                'last_name' => 'Admin',
                'email'     => 'admin@nhanh.com',
                'password'  => Hash::make(config('core.default.password')),
                'role_id'   => 1,
            ]
        ];
        foreach ($list as $item) {
            $user = User::query()->updateOrCreate(["email" => $item["email"]], $item);
            $user->assignRole($item["role_id"]);
        }
    }
}