<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Onair;
use App\Models\Music;
use App\Models\SongRequest;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SongRequest>
 */
class SongRequestFactory extends Factory
{
    /**
     * Define the model's default state.
    *
    * @return array<string, mixed>
    */

    protected $model = SongRequest::class;

    public function definition(): array
    {
        return [
            'is_played' => false,
            'onair_id' => Onair::factory()->create(),
            'music_id' => Music::factory()->create(),
            'ip' => fake()->ipv4(),
            'name' => fake()->nickName(),
            'address' => fake()->address(),
            'message' => fake()->sentence()
        ];
    }
}
