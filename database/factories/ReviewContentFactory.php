<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Review;
use App\Models\ReviewContent;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReviewContent>
 */
class ReviewContentFactory extends Factory
{
    /**
     * Define the model's default state.
    *
    * @return array<string, mixed>
    */

    protected $model = ReviewContent::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'review_id' => Review::factory()->create(),
            'content' => fake()->paragraph(),
        ];
    }
}
