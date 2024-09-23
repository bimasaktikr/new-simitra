<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('teams')->insert([
            [
                'id' => 1,
                'name' => 'Distribusi',
                'code' => 'TA'
            ],
            [
                'id' => 2,
                'name' => 'IPDS',
                'code' => 'TB'
            ],
            [
                'id' => 3,
                'name' => 'Neraca',
                'code' => 'TC'
            ],
            [
                'id' => 4,
                'name' => 'Produksi',
                'code' => 'TD'
            ],
            [
                'id' => 5,
                'name' => 'Sosial',
                'code' => 'TE'
            ],
            [
                'id' => 6,
                'name' => 'Umum',
                'code' => 'UM'
            ],
        ]);
    }
}
