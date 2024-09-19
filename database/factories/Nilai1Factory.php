<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nilai1>
 */
class Nilai1Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $aspek1 = $this->faker->numberBetween(1, 5);
        $aspek2 = $this->faker->numberBetween(1, 5);
        $aspek3 = $this->faker->numberBetween(1, 5);
        $rerata = round(($aspek1 + $aspek2 + $aspek3) / 3, 2);

        return [
            'transaction_id' => null, // We'll assign this in the seeder to ensure uniqueness
            'aspek1' => $aspek1,
            'aspek2' => $aspek2,
            'aspek3' => $aspek3,
            'rerata' => $rerata,
        ];
    }
}
