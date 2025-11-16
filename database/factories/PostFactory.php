<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realTextBetween(10, 255),
            'content' => fake()->realTextBetween(200, 1000),
            'img_path' => fake()->imageUrl(),
            'category_id' => Category::inRandomOrder()->first()->id,
            'profile_id' => Profile::inRandomOrder()->first()->id,
            'published_at' => fake()->dateTime(),
            'is_active' => fake()->boolean()
        ];
    }
}
