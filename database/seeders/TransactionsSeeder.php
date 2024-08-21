<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('transactions')->insert([
            [
                'id' => 1,
                'mitra_id' => 212112328,
                'survey_id' => 1,
                'target' => 'Target A',
                'payment' => 1000,
                'nilai' => 4
            ],
            [
                'id' => 2,
                'mitra_id' => 212112287,
                'survey_id' => 2,
                'target' => 'Target B',
                'payment' => 2000,
                'nilai' => 4.33
            ],
            [
                'id' => 3,
                'mitra_id' => 212112328,
                'survey_id' => 3,
                'target' => 'Target C',
                'payment' => 1500,
                'nilai' => 4.67
            ],
            [
                'id' => 4,
                'mitra_id' => 212112328,
                'survey_id' => 4,
                'target' => 'Target D',
                'payment' => 2500,
                'nilai' => 5
            ],
            [
                'id' => 5,
                'mitra_id' => 212112287,
                'survey_id' => 5,
                'target' => 'Target E',
                'payment' => 3000,
                'nilai' => 4
            ],
        ]);
    }
}
