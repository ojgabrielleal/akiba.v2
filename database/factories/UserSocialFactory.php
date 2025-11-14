<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\UserSocial;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSocial>
 */
class UserSocialFactory extends Factory
{
    /**
     * Define the model's default state.
    *
    * @return array<string, mixed>
    */

    protected $model = UserSocial::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'name' => fake()->sentence(),
            'url' => fake()->url(),
        ];
    }
}
