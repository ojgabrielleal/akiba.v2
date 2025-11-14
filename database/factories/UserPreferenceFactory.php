<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\UserPreference;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPreference>
 */
class UserPreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
    *
    * @return array<string, mixed>
    */

    protected $model = UserPreference::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'is_like' => fake()->boolean(0.5),
            'content' => fake()->sentence(),
        ];
    }
}
