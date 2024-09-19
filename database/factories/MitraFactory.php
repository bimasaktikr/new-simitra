<?php

namespace Database\Factories;

use App\Models\Mitra;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mitra>
 */
class MitraFactory extends Factory
{
    protected $model = Mitra::class;

    public function definition()
    {
        // Create a user first, so its email is available
        $user = User::factory()->create(); 

        return [
            'name' => $this->faker->name(),
            'email' => $user->email,  // Use the user's email
            'pendidikan' => $this->faker->randomElement(['SMA', 'D3', 'S1', 'S2']),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '2000-01-01'),
        ];
    }
}
