<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\PostReaction;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostReaction>
 */
class PostReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PostReaction::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory()->create(),
            'type' => fake()->randomElement(['like', 'unlike', 'sad'])
        ];
    }
}
