<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Survey>
 */
class SurveyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        // Generate a start date
        $start_date = $this->faker->dateTimeBetween('2024-01-01', '2024-12-31');

        // Generate an end date that is always after the start date
        $end_date = $this->faker->dateTimeBetween($start_date, '2024-12-31');

        return [
            'name' => $this->faker->word(),
            'code' => $this->faker->unique()->word(),
            'payment_type_id' => $this->faker->numberBetween(1, 2),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'payment' => $this->faker->numberBetween(100000, 500000),
            'team_id' => $this->faker->numberBetween(1, 5),
            'is_sudah_dinilai' => $this->faker->boolean(),
        ];
    }
}
