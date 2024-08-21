<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mitras')->insert([
            ['id' => 1, 
            'role' => Admin,],
            ['id' => 2, 
            'role' => Employee,],
            ['id' => 3, 
            'role' => Mitra,],
        ]);
    }
}
