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
                'team_id' => 1,
                'name' => 'Team A',
                'code' => 'TA'
            ],
            [
                'team_id' => 2,
                'name' => 'Team B',
                'code' => 'TB'
            ],
            [
                'team_id' => 3,
                'name' => 'Team C',
                'code' => 'TC'
            ],
            [
                'team_id' => 4,
                'name' => 'Team D',
                'code' => 'TD'
            ],
            [
                'team_id' => 5,
                'name' => 'Team E',
                'code' => 'TE'
            ],
        ]);
    }
}
