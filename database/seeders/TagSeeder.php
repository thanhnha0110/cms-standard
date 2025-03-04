<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
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
                'name' => 'new',
                'slug' => 'new',
            ],
            [
                'name' => 'hot',
                'slug' => 'hot',
            ],
        ];

        foreach ($list as $item) {
            Tag::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}