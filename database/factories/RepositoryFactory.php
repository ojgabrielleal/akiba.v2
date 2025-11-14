<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Repository;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Repository>
 */
class RepositoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Repository::class; 

    public function definition(): array
    {
        return [
            'is_active' => true,
            'image' => fake()->url(),
            'url' => fake()->url(),
            'type' => fake()->randomElement(['tutorial, package, installer']),
            'name' => fake()->nickName(),
        ];
    }
}
