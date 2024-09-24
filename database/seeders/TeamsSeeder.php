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
                'id' => 4,
                'name' => 'Distribusi',
                'code' => 'TA'
            ],
            [
                'id' => 6,
                'name' => 'IPDS',
                'code' => 'TB'
            ],
            [
                'id' => 5,
                'name' => 'Neraca',
                'code' => 'TC'
            ],
            [
                'id' => 3,
                'name' => 'Produksi',
                'code' => 'TD'
            ],
            [
                'id' => 2,
                'name' => 'Sosial',
                'code' => 'TE'
            ],
            [
                'id' => 1,
                'name' => 'Umum',
                'code' => 'UM'
            ],
        ]);
    }
}
