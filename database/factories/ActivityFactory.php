<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'content' => fake()->paragraph(),
            'limit' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'allows_confirmations' => fake()->boolean(),
        ];
    }
}
