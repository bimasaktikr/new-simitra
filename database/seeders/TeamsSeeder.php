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
                'name' => 'Team A',
                'code' => 'TA'
            ],
            [
                'id' => 2,
                'name' => 'Team B',
                'code' => 'TB'
            ],
            [
                'id' => 3,
                'name' => 'Team C',
                'code' => 'TC'
            ],
            [
                'id' => 4,
                'name' => 'Team D',
                'code' => 'TD'
            ],
            [
                'id' => 5,
                'name' => 'Team E',
                'code' => 'TE'
            ],
        ]);
    }
}
