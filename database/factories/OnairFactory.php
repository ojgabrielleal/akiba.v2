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
            'type' => 'human',
            'image' => 'https://placehold.co/600x400?text=Akiba',
            'allows_songs_requests' => true,
            'song_request_count' => fake()->randomNumber()
        ];
    }
}
