<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
    *
    * @return array<string, mixed>
    */

    protected $model = User::class;

    public function definition(): array
    {
        return [
            'is_active' => true,
            'slug' => fake()->slug(),
            'username' => fake()->userName(),
            'password' => Hash::make(fake()->password()),
            'name' => fake()->name(),
            'nickname' => fake()->userName(),
            'gender' => fake()->randomElement(['male', 'female']),
            'avatar' => fake()->url(),
            'birthday' => fake()->date(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'bibliography' => fake()->paragraph(),
        ];
    }
}
