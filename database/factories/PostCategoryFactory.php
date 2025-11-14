<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\PostCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostCategory>
 */
class PostCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PostCategory::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory()->create(),
            'type' => fake()->randomElement(['anime', 'manga', 'light-novel', 'news', 'events'])
        ];
    }
}
