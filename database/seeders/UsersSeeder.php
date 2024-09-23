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
            'email' => 'ketuatim1@example.com', 
            'password' => bcrypt('password1'),
            'role_id' => 2,
            'status' => 'Aktif'],

            ['id' => 2, 
            'email' => 'ketuatim2@example.com', 
            'password' => bcrypt('password2'),
            'role_id' => 2,
            'status' => 'Aktif'],

            ['id' => 3, 
            'email' => 'ketuatim3@example.com', 
            'password' => bcrypt('password3'),
            'role_id' => 2,
            'status' => 'Aktif'],
            
            ['id' => 4, 
            'email' => 'ketuatim4@example.com', 
            'password' => bcrypt('password4'),
            'role_id' => 2,
            'status' => 'Aktif'],

            ['id' => 5, 
            'email' => 'ketuatim5@example.com', 
            'password' => bcrypt('password5'),
            'role_id' => 2,
            'status' => 'Aktif'],

            ['id' => 6, 
            'email' => 'admin@example.com', 
            'password' => bcrypt('admin'),
            'role_id' => 1,
            'status' => 'Aktif'],
        ]);
    }
}