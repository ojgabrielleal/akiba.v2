<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
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
            'cover' => fake()->url(),
            'image' => fake()->url(),
            'slug' => fake()->slug(),
            'title' => fake()->title(),
            'content' => fake()->paragraph(),
            'dates' => fake()->words(3),
            'address' => fake()->address(),
        ];
    }
}
