<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MitrasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mitras')->insert([
            ['id_sobat' => 212112328,
            'name' => 'Rissa Erviana',
            'email' => 'user3@example.com', 
            'pendidikan' => 'S1', 
            'jenis_kelamin' => 'Perempuan', 
            'tanggal_lahir' => '2003-02-02'],

            ['id_sobat' => 212112287, 
            'name' => 'Pretty Melati Pardede', 
            'email' => 'user4@example.com', 
            'pendidikan' => 'S1', 
            'jenis_kelamin' => 'Perempuan', 
            'tanggal_lahir' => '2003-01-01'],
        ]);
    }
}
