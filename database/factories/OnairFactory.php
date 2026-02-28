<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Onair>
 */
class OnairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_live' => true,
            'phrase' => fake()->sentence(),
            'type' => fake()->randomElement(['auto', 'playlist', 'record', 'live']),
            'image' => 'https://placehold.co/500x500?text=Rede%20Akiba%20Placeholder',
            'allows_song_requests' => true,
            'song_requests_total' => fake()->randomNumber()
        ];
    }
}
