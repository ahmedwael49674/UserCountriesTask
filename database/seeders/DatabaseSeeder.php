<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // load database.sql
        // $path = str_replace("seeders", "database.sql", __DIR__);
        // DB::unprepared($path);

        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            UserDetailSeeder::class,
        ]);
    }
}
