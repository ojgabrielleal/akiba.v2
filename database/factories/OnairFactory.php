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
            'is_playlist' => false,
            'phrase' => fake()->sentence(),
            'type' => 'human',
            'image' => fake()->url(),
            'listener_request_toggle' => true,
            'listener_request_total' => fake()->randomNumber()
        ];
    }
}
