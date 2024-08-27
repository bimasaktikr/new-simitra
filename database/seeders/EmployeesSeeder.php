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
            'jenis_kelamin' => 'Perempuan',
            'email' => 'user1@example.com',
            'tanggal_lahir' => '2002-01-01',
            'team_id' => 1,
            'peran' => 'Ketua tim'],

            ['id' => 2, 
            'name' => 'Bintana Tajmala', 
            'nip' => '212111957', 
            'jenis_kelamin' => 'Perempuan',
            'email' => 'user2@example.com', 
            'tanggal_lahir' => '2002-01-01',
            'team_id' => 3,
            'peran' => 'Anggota'],

            ['id' => 3,  
            'name' => 'Elvina Gamayanti', 
            'nip' => '212111957', 
            'jenis_kelamin' => 'Perempuan',
            'email' => 'admin@example.com', 
            'tanggal_lahir' => '2002-01-01',
            'team_id' => 2,
            'peran' => 'Anggota'],
        ]);
    }
}
