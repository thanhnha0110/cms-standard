<?php

namespace Database\Seeders;

use App\Models\Timezone;
use Illuminate\Database\Seeder;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = json_decode(file_get_contents('timezones.json'));
        foreach ($list as $item) {
            Timezone::updateOrCreate(['zone' => $item->zone], (array) $item);
        }
    }
}