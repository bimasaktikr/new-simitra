<?php

namespace Database\Factories;

use App\Models\Nilai2;
use App\Models\MitraTeladan;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class Nilai2Factory extends Factory
{
    protected $model = Nilai2::class;

    public function definition()
    {
        $aspek1 = $this->faker->numberBetween(3, 5);
        $aspek2 = $this->faker->numberBetween(3, 5);
        $aspek3 = $this->faker->numberBetween(3, 5);
        $aspek4 = $this->faker->numberBetween(3, 5);
        $aspek5 = $this->faker->numberBetween(3, 5);
        $aspek6 = $this->faker->numberBetween(3, 5);
        $aspek7 = $this->faker->numberBetween(3, 5);
        $aspek8 = $this->faker->numberBetween(3, 5);
        $aspek9 = $this->faker->numberBetween(3, 5);
        $aspek10 = $this->faker->numberBetween(3, 5);
        $rerata = round((
            $aspek1 + $aspek2 + $aspek3 + $aspek4 + $aspek5 +
            $aspek6 + $aspek7 + $aspek8 + $aspek9 + $aspek10
        ) / 10, 2);

        return [
            'mitra_teladan_id' => $this->getMitraTeladanIdWithoutNilai2(), // Random mitra teladan
            'team_penilai_id' => Team::inRandomOrder()->first()->id, // Random team
            'aspek1' => $aspek1,
            'aspek2' => $aspek2,
            'aspek3' => $aspek3,
            'aspek4' => $aspek4,
            'aspek5' => $aspek5,
            'aspek6' => $aspek6,
            'aspek7' => $aspek7,
            'aspek8' => $aspek8,
            'aspek9' => $aspek9,
            'aspek10' => $aspek10,
            'rerata' => $rerata,
            'is_final' => true, // Random final status
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function getMitraTeladanIdWithoutNilai2()
    {
        $mitraTeladanIds = MitraTeladan::whereDoesntHave('nilai2', function($query) {
            // This will check if any team_penilai_id (1-6) is missing for a MitraTeladan
            $query->whereBetween('team_penilai_id', [1, 6]);
        }, '<', 6)->pluck('id');
        // if ($mitraTeladanIds->isEmpty()) {
        //     // If no MitraTeladan records without Nilai2, create a new one
        //     // $mitraTeladan = MitraTeladan::factory()->create();
        //     return $mitraTeladan->id;
        // } else {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
        //     return $mitraTeladanIds->random();
        // }
        // dd($mitraTeladanIds);
        return $mitraTeladanIds;
    }
}

