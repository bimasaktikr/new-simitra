<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            ['id' => 1, 
            'email' => 'user1@example.com', 
            'password' => bcrypt('password1'),
            'role_id' => 2],

            ['id' => 2, 
            'email' => 'user2@example.com', 
            'password' => bcrypt('password2'),
            'role_id' => 3],

            ['id' => 3, 
            'email' => 'user3@example.com', 
            'password' => bcrypt('password3'),
            'role_id' => 4],
            
            ['id' => 4, 
            'email' => 'user4@example.com', 
            'password' => bcrypt('password4'),
            'role_id' => 4],

            ['id' => 5, 
            'email' => 'admin@example.com', 
            'password' => bcrypt('admin'),
            'role_id' => 1],
        ]);
    }
}