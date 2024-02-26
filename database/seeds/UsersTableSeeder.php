<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'name' => 'Helder Galeano',
            'password' => bcrypt(123456),
            'email' => 'helder.galeano@gmail.com',
            'role' => 2
        ]);
    }
}
