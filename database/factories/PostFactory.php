<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;

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

    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'is_active' => true,
            'user_id' => User::factory()->create(),
            'image' => fake()->url(),
            'slug' => fake()->slug(),
            'title' => fake()->title(),
            'content' => fake()->paragraph(),
            'cover' => fake()->url(),
            'type' => fake()->randomElement(['published', 'revision', 'sketch'])
        ];
    }
}
