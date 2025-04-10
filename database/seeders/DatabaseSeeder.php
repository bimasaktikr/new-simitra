<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VariabelPenilaian;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            UsersSeeder::class,
            TeamsSeeder::class,
            EmployeesSeeder::class,
            FaqsSeeder::class,
            // MitrasSeeder::class,
            PaymentTypesSeeder::class,
            // SurveysSeeder::class,
            // TransactionsSeeder::class,
            // UsersSeeder::class,
            // VariabelPenilaian::class,
        ]);
    }
}
