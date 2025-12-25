<?php

namespace Tests\Feature\Models\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Post;
use App\Models\PostReference;
use App\Models\PostReaction;
use App\Models\PostCategory;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsTheUserOnReturn(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $post->user->first());
    }

    public function testContainsPostReferencesOnReturn(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->has(PostReference::factory()->count(3), 'references')->create();

        $this->assertInstanceOf(PostReference::class, $post->references->first());
        $this->assertCount(3, $post->references);
    }

    public function testContainsPostReactionsOnReturn(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->has(PostReaction::factory()->count(3), 'reactions')->create();

        $this->assertInstanceOf(PostReaction::class, $post->reactions->first());
        $this->assertCount(3, $post->reactions);
    }

    public function testContainsPostCategoriesOnReturn(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->has(PostCategory::factory()->count(3), 'categories')->create();


        $this->assertInstanceOf(PostCategory::class, $post->categories->first());
        $this->assertCount(3, $post->categories);
    }
}
