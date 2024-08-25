<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            ['id' => 1, 
            'name' => 'Azmira Candra Vidiasari', 
            'nip' => '212111941',
            'email' => 'user1@example.com', 
            'team_id' => 1],

            ['id' => 2, 
            'name' => 'Bintana Tajmala', 
            'nip' => '212111957', 
            'email' => 'user2@example.com', 
            'team_id' => 2],

            ['id' => 3,  
            'name' => 'Elvina Gamayanti', 
            'nip' => '212111957', 
            'email' => 'admin@example.com', 
            'team_id' => NULL],
        ]);
    }
}
