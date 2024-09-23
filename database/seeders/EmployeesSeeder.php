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
            'name' => 'Ketua Tim 1', 
            'nip' => '212111941',
            'jenis_kelamin' => 'Perempuan',
            'user_id' => 1,
            'tanggal_lahir' => '2002-01-01',
            'team_id' => 1],

            ['id' => 2, 
            'name' => 'Ketua Tim 2', 
            'nip' => '212111957', 
            'jenis_kelamin' => 'Perempuan',
            'user_id' => 2, 
            'tanggal_lahir' => '2002-01-01',
            'team_id' => 2],

            ['id' => 3, 
            'name' => 'Ketua Tim 3', 
            'nip' => '212111957', 
            'jenis_kelamin' => 'Perempuan',
            'user_id' => 3, 
            'tanggal_lahir' => '2002-01-01',
            'team_id' => 3],

            ['id' => 4, 
            'name' => 'Ketua Tim 4', 
            'nip' => '212111957', 
            'jenis_kelamin' => 'Perempuan',
            'user_id' => 4, 
            'tanggal_lahir' => '2002-01-01',
            'team_id' => 4],

            ['id' => 5, 
            'name' => 'Ketua Tim 5', 
            'nip' => '212111957', 
            'jenis_kelamin' => 'Perempuan',
            'user_id' => 5, 
            'tanggal_lahir' => '2002-01-01',
            'team_id' => 5],

            ['id' => 6,  
            'name' => 'Elvina Gamayanti', 
            'nip' => '212111957', 
            'jenis_kelamin' => 'Perempuan',
            'user_id' => 6  , 
            'tanggal_lahir' => '2002-01-01',
            'team_id' => 6],
        ]);
    }
}
