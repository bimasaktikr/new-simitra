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
                'target' => 5,
                'payment' => 100000,
                'total_payment' => 500000,
            ],
            [
                'id' => 2,
                'mitra_id' => 212112287,
                'survey_id' => 2,
                'target' => 10,
                'payment' => 200000,
                'total_payment' => 2000000,
            ],
            [
                'id' => 3,
                'mitra_id' => 212112328,
                'survey_id' => 3,
                'target' => 20,
                'payment' => 50000,
                'total_payment' => 1000000,
            ]
        ]);
    }
}
