<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
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
            'slug' => fake()->slug(),
            'name' => fake()->name(),
            'image' => fake()->url(),
            'allows_all' => fake()->boolean(),
            'has_schedule' => fake()->boolean(),
        ];
    }
}
