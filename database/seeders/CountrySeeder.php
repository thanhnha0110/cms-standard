<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = json_decode(file_get_contents('countries.json'));
        foreach ($list as $item) {
            Country::updateOrCreate(['code' => $item->code], (array) $item);
        }
    }
}