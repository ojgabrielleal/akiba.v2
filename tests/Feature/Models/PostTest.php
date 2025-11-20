<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Post;
use App\Models\PostReference;
use App\Models\PostReaction;

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
        $post = Post::factory()->for($user)->create();

        PostReference::factory()->count(3)->create([
            'post_id' => $post->id
        ]);

        $this->assertInstanceOf(PostReference::class, $post->postReference->first());
        $this->assertCount(3, $post->postReference);
    }

    public function testContainsPostReactionsOnReturn(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        PostReaction::factory()->count(3)->create([
            'post_id' => $post->id
        ]);

        $this->assertInstanceOf(PostReaction::class, $post->postReaction->first());
        $this->assertCount(3, $post->postReaction);
    }

    public function testContainsPostCategoriesOnReturn(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create();

        PostReaction::factory()->count(3)->create([
            'post_id' => $post->id
        ]);

        $this->assertInstanceOf(PostReaction::class, $post->postReaction->first());
        $this->assertCount(3, $post->postReaction);
    }
}
