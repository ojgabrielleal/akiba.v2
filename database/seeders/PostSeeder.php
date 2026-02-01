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
        $user = User::factory()->create();
        $reference = PostReference::factory()->count(3);
        $reaction = PostReaction::factory()->count(3);
        $category = PostCategory::factory()->count(3);

        Post::factory()
            ->for($user, 'author')
            ->has($reference, 'references')
            ->has($reaction, 'reactions')
            ->has($category, 'categories')
            ->create();

    }
}
