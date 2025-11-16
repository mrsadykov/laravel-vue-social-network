<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $commentableClass = $this->faker->randomElement([
            Post::class,
            // ...
        ]);

        return [
            'content' => fake()->realTextBetween(255, 1000),
            'published_at' => fake()->dateTime(),
            'profile_id' => Profile::inRandomOrder()->first()->id,
            'post_id' => Post::inRandomOrder()->first()->id
            //'commentable_id' => $commentableClass::factory(),
            //'commentable_type' => $commentableClass,
        ];
    }
}
