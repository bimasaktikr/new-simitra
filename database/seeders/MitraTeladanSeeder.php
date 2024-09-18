<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mitra;
use App\Models\Survey;
use App\Models\Transaction;
use App\Models\Nilai1;

class MitraTeladanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed Mitra
        Mitra::factory()->count(200)->create();

        // Seed Surveys for the year 2024
        Survey::factory()->count(20)->create();

        // Seed Transactions
        $transactions = Transaction::factory()->count(400)->create();

        // Seed Nilai1
        // For each transaction, create a corresponding Nilai1
        foreach ($transactions as $transaction) {
            Nilai1::factory()->create([
                'transaction_id' => $transaction->id, // Assign each transaction its own Nilai1
            ]);
        }
    }
}
