<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            ['user_id' => 1, 'email' => 'user1@example.com', 'password' => bcrypt('password1')],
            ['user_id' => 2, 'email' => 'user2@example.com', 'password' => bcrypt('password2')],
            ['user_id' => 3, 'email' => 'user3@example.com', 'password' => bcrypt('password3')],
            ['user_id' => 4, 'email' => 'user4@example.com', 'password' => bcrypt('password4')],
        ]);
    }
}