<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
    *
    * @return array<string, mixed>
    */

    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'is_active' => true,
            'user_id' => User::factory()->create(),
            'is_completed' => false,
            'deadline' => fake()->date(),
            'title' => fake()->words(5, true),
            'content' => fake()->paragraph(),
        ];
    }
}
