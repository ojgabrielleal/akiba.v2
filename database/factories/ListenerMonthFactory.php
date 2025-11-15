<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ListenerMonth>
 */
class ListenerMonthFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'avatar' => fake()->url(),
            'address' => fake()->address(),
            'favorite_show' => fake()->name(),
            'requests_total' => fake()->number(),
        ];
    }
}
