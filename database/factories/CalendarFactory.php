<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calendar>
 */
class CalendarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'time' => fake()->time(),
            'date' => fake()->date(),
            'type' => fake()->randomElement(['show', 'live', 'youtube', 'podcast']),
            'content' => fake()->word()
        ];
    }
}
