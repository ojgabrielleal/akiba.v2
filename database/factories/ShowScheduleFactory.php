<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Show;
use App\Models\ShowSchedule;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShowSchedule>
 */
class ShowScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
    *
    * @return array<string, mixed>
    */

    protected $model = ShowSchedule::class;

    public function definition(): array
    {
        return [
            'show_id' => Show::factory()->create(),
            'day' => fake()->randomElement([0, 1, 2, 3, 4, 5, 6]),
            'time' => fake()->time(),
        ];
    }
}
