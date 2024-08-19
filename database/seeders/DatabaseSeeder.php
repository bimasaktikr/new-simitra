<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            EmployeesSeeder::class,
            FaqsSeeder::class,
            MitrasSeeder::class,
            PaymentTypesSeeder::class,
            SurveysSeeder::class,
            TeamsSeeder::class,
            TransactionsSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
