<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;

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

    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'is_active' => true, 
            'slug' => fake()->slug(),
            'cover' => fake()->url(),
            'image' => fake()->url(),
            'title' => fake()->title(),
            'sinopse' => fake()->paragraph(),
        ];
    }
}
