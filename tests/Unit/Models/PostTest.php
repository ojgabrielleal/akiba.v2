<?php

namespace Tests\Unit\Models;

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

    public function testAuthorRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $post = Post::factory()
            ->for($user, 'author')
            ->create();

        $this->assertTrue($post->author->is($user));
    }

    public function testReferencesRelationshipReturnsPostReferences(): void
    {
        $user = User::factory()->create();
        $reference = PostReference::factory()->count(3);

        $post = Post::factory()
            ->for($user, 'author')
            ->has($reference, 'references')
            ->create();

        $this->assertCount(3, $post->references);
        $this->assertContainsOnlyInstancesOf(
            PostReference::class, 
            $post->references
        );
    }

    public function testReactionsRelationshipReturnsPostReactions(): void
    {
        $user = User::factory()->create();
        $reaction = PostReaction::factory()->count(3);

        $post = Post::factory()
            ->for($user, 'author')
            ->has($reaction, 'reactions')
            ->create();

        $this->assertCount(3, $post->reactions);
        $this->assertContainsOnlyInstancesOf(
            PostReaction::class, 
            $post->reactions
        );
    }

    public function testCategoriesRelationshipReturnsPostCategories(): void
    {
        $user = User::factory()->create();
        $category = PostCategory::factory()->count(3);

        $post = Post::factory()
            ->for($user, 'author')
            ->has($category, 'categories')
            ->create();

        $this->assertCount(3, $post->categories);
        $this->assertContainsOnlyInstancesOf(
            PostCategory::class, 
            $post->categories
        );
    }
}
