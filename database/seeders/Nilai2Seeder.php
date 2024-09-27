<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use App\Models\MitraTeladan;
use App\Models\Nilai2;

class Nilai2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed MitraTeladan records
        $mitraTeladans = MitraTeladan::all();
        $employeeIds = Employee::where('id', '!=', 28)->pluck('id');

        // For each MitraTeladan, create corresponding Nilai2 records
        foreach ($mitraTeladans as $mitraTeladan) {
            foreach ($employeeIds as $employeeId) {
                Nilai2::factory()->create([
                    'mitra_teladan_id' => $mitraTeladan->id,
                    'employee_id' => $employeeId,
                ]);
            }
        }
    }
}
