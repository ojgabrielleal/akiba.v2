<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
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
            'sinopse' => fake()->paragraph(),
        ];
    }
}
