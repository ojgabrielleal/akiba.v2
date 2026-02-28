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
            'image' => 'https://placehold.co/500x500?text=Rede%20Akiba%20Placeholder',
            'title' => fake()->text(),
            'content' => fake()->paragraph(),
            'cover' => 'https://placehold.co/500x500?text=Rede%20Akiba%20Placeholder',
            'type' => fake()->randomElement(['published', 'revision', 'draft'])
        ];
    }
}
