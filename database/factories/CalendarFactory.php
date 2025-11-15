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
            'start_time' => fake()->dateTime(),
            'end_time' => fake()->dateTime(),
            'type' => fake()->randomElement(['show', 'live', 'video', 'podcast']),
            'content' => fake()->word()
        ];
    }
}
