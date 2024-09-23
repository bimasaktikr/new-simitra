<?php

namespace Database\Seeders;

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

        // For each MitraTeladan, create corresponding Nilai2 records
        foreach ($mitraTeladans as $mitraTeladan) {
                foreach (range(1, 6) as $teamId) {
                    Nilai2::factory()->create([
                        'mitra_teladan_id' => $mitraTeladan->id,
                        'team_penilai_id' => $teamId,
                    ]);
                }
            }
    }
}
