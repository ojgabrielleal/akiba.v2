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
            'cover' => 'https://placehold.co/900x900?text=Akiba',
            'image' => 'https://placehold.co/900x900?text=Akiba',
            'title' => fake()->word(),
            'content' => fake()->paragraph(),
            'dates' => fake()->word(),
            'address' => fake()->address(),
        ];
    }
}
