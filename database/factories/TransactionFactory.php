<?php

namespace Database\Factories;

use App\Models\Mitra;
use App\Models\Survey;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mitra_id' => Mitra::inRandomOrder()->first()->id_sobat, // Get random mitra_id
            'survey_id' => Survey::inRandomOrder()->first()->id, 
            'target' => $this->faker->numberBetween(1, 100),
            'payment' => $this->faker->numberBetween(1000000, 3000000),
            // 'total_payment' => $this->faker->numberBetween(200000, 1000000),
        ];
    }
}
