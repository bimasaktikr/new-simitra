<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_types')->insert([
            ['id' => 1, 
            'payment_type' => 'Bulanan'],
            ['id' => 2, 
            'payment_type' => 'Per Dokumen'],
        ]);
    }
}
