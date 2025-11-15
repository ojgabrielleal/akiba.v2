<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Show>
 */
class ShowFactory extends Factory
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
            'name' => fake()->nickName(),
            'image' => fake()->url(),
            'is_all' => false,
            'has_schedule' => true,
        ];
    }
}
