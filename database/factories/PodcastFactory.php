<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Podcast>
 */
class PodcastFactory extends Factory
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
            'title' => fake()->word(),
            'image' => fake()->url(),
            'season' => fake()->randomNumber(),
            'episode' => fake()->randomNumber(),
            'summary' => fake()->paragraph(),
            'description' => fake()->paragraph(),
            'audio' => fake()->url(),
        ];
    }
}
