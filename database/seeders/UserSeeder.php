<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
        ['id' => 1, 'email' =>'alex@tempmail.com',   'active' => 1, 'created_at' =>'2020-01-19 16:08:59', 'updated_at' =>'2020-01-19 16:08:59'],
        ['id' => 2, 'email' =>'maria@tempmail.com',  'active' => 1, 'created_at' =>'2020-01-19 16:08:59', 'updated_at' =>'2020-01-19 16:08:59'],
        ['id' => 3, 'email' =>'john@tempmail.com',   'active' => 1, 'created_at' =>'2020-01-19 16:08:59', 'updated_at' =>'2020-01-19 16:08:59'],
        ['id' => 4, 'email' =>'dominik@test.com',    'active' => 0, 'created_at' =>'2020-01-19 16:08:59', 'updated_at' =>'2020-01-19 16:08:59'],
        ['id' => 5, 'email' =>'andreas@yahoo.de',    'active' => 0, 'created_at' =>'2020-01-19 16:08:59', 'updated_at' =>'2020-01-19 16:08:59'],
        ['id' => 6, 'email' =>'Taaaaaaa@test.com',   'active' => 1, 'created_at' =>'2020-01-19 16:08:59', 'updated_at' =>'2020-01-19 16:08:59'],
        ['id' => 7, 'email' =>'rerere@test_mail.com','active' => 1, 'created_at' =>'2020-01-19 16:08:59', 'updated_at' =>'2020-01-19 16:08:59']
        ];

        DB::table('users')->insert($users);
    }
}
