<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                'name' => 'Blog',
            ],
            [
                'name' => 'News',
            ],
        ];

        foreach ($list as $item) {
            Category::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}