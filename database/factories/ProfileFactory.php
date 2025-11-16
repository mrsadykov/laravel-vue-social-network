<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'second_name' => fake()->word,
            'third_name' => fake()->word,
            'avatar' => fake()->imageUrl(),
            'city' => fake()->city,
            'login' => fake()->unique()->word,
            'user_id' => User::inRandomOrder()->first()->id //User::factory()
        ];
    }
}
