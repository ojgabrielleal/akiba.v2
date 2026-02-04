<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Post;
use App\Models\PostReference;
use App\Models\PostReaction;
use App\Models\PostCategory;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()
            ->count(5)
            ->for(User::factory()->create(), 'author')
            ->has(PostReference::factory()->count(3), 'references')
            ->has(PostReaction::factory()->count(3), 'reactions')
            ->has(PostCategory::factory()->count(3), 'categories')
            ->create();

        Post::factory()
            ->count(5)
            ->for(User::find(1), 'author')
            ->has(PostReference::factory()->count(3), 'references')
            ->has(PostReaction::factory()->count(3), 'reactions')
            ->has(PostCategory::factory()->count(3), 'categories')
            ->create();
    }
}
