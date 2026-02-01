<?php

namespace Database\Factories;

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
            'is_active' => true,
            'image' => 'https://placehold.co/600x400?text=Akiba',
            'title' => fake()->word(),
            'content' => fake()->paragraph(),
            'cover' => 'https://placehold.co/600x400?text=Akiba',
            'status' => fake()->randomElement(['published', 'revision', 'sketch'])
        ];
    }
}
