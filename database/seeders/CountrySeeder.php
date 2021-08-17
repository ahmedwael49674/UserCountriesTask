<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            ['id' => 1, 'name' => 'Austria',                'iso2' =>  'AT', 'iso3' =>  'AUT'] ,
            ['id' => 2, 'name' => 'France',                 'iso2' =>  'FR', 'iso3' =>  'FRA'] ,
            ['id' => 3, 'name' => 'Germany',                'iso2' =>  'DE', 'iso3' =>  'DEU'] ,
            ['id' => 4, 'name' => 'Spain',                  'iso2' =>  'ES', 'iso3' =>  'ESP'] ,
            ['id' => 5, 'name' => 'Russian Federation',     'iso2' =>  'RU', 'iso3' =>  'RUS'] ,
            ['id' => 6, 'name' => 'China',                  'iso2' =>  'CN', 'iso3' =>  'CHN'] ,
        ];

        DB::table('countries')->insert($countries);
    }
}
