<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\PostReference;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostReference>
 */
class PostReferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = PostReference::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory()->create(),
            'name' => fake()->domainWord(),
            'url' => fake()->url(),
        ];
    }
}
