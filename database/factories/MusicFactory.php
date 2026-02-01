<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Music>
 */
class MusicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['OP', 'ED']),
            'production' => fake()->word(),
            'image' => 'https://placehold.co/600x400?text=Akiba',
            'artist' => fake()->name(),
            'name' => fake()->name(),
            'in_ranking' => fake()->boolean(0.5),
            'image_ranking' => '/img/default/avatar.webp',
            'song_request_count' => fake()->randomDigit(),
        ];
    }
}
