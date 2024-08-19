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
            ['mitra_id' => 212112328, 
            'user_id' => 3, 
            'name' => 'Rissa Erviana', 
            'pendidikan' => 'S1', 
            'jenis_kelamin' => 'Perempuan', 
            'umur' => 21],

            ['mitra_id' => 212112287, 
            'user_id' => 4, 
            'name' => 'Pretty Melati Pardede', 
            'pendidikan' => 'S1', 
            'jenis_kelamin' => 'Perempuan', 
            'umur' => 21],
        ]);
    }
}
