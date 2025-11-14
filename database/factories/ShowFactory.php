<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Show;

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

    protected $model = Show::class;

    public function definition(): array
    {
        return [
            'is_active' => true,
            'user_id' => User::factory()->create(),
            'slug' => fake()->slug(),
            'name' => fake()->nickName(),
            'image' => fake()->url(),
            'is_all' => false,
            'has_schedule' => true,
        ];
    }
}
