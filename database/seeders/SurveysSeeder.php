<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveysSeeder extends Seeder
{
    public function run()
    {
        DB::table('surveys')->insert([
            [
                'id' => 1,
                'name' => 'Survey A',
                'code' => 'SA',
                'payment_type_id' => 1,
                'start_date' => '2024-01-01',
                'end_date' => '2024-12-31',
                'payment' => 1000000,
                'team_id' => 1
            ],
            [
                'id' => 2,
                'name' => 'Survey B',
                'code' => 'SB',
                'payment_type_id' => 2,
                'start_date' => '2024-02-01',
                'end_date' => '2024-11-30',
                'payment' => 20000,
                'team_id' => 2
            ],
            [
                'id' => 3,
                'name' => 'Survey C',
                'code' => 'SC',
                'payment_type_id' => 2,
                'start_date' => '2024-03-01',
                'end_date' => '2024-10-31',
                'payment' => 50000,
                'team_id' => 3
            ],
            [
                'id' => 4,
                'name' => 'Survey D',
                'code' => 'SD',
                'payment_type_id' => 1,
                'start_date' => '2024-04-01',
                'end_date' => '2024-09-30',
                'payment' => 2500,
                'team_id' => 4
            ],
            [
                'id' => 5,
                'name' => 'Survey E',
                'code' => 'SE',
                'payment_type_id' => 1,
                'start_date' => '2024-05-01',
                'end_date' => '2024-08-31',
                'payment' => 3000,
                'team_id' => 5
            ],
        ]);
    }
}
