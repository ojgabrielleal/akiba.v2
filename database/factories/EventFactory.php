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
            'cover' => 'https://placehold.co/500x500?text=Rede%20Akiba%20Placeholder',
            'image' => 'https://placehold.co/500x500?text=Rede%20Akiba%20Placeholder',
            'title' => fake()->word(),
            'content' => fake()->paragraph(),
            'dates' => fake()->word(),
            'address' => fake()->address(),
        ];
    }
}
