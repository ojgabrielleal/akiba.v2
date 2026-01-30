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

    /**
     * Tests from Post model relationships.
     */
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

    /**
     * Tests from Post model scopes.
     */
    public function testScopeActiveReturnsOnlyActivePosts(): void
    {
        $user = User::factory()->create();

        $activePost = Post::factory()
            ->for($user, 'author')
            ->state(['is_active' => true])
            ->create();

        $inactivePost = Post::factory()
            ->for($user, 'author')
            ->state(['is_active' => false])
            ->create();

        $activePosts = Post::active()->get();

        $this->assertTrue($activePosts->contains($activePost));
        $this->assertFalse($activePosts->contains($inactivePost));
    }

    public function testScopePublishedReturnsOnlyPublishedPosts(): void
    {
        $user = User::factory()->create();

        $publishedPost = Post::factory()
            ->for($user, 'author')
            ->state(['status' => 'published'])
            ->create();

        $draftPost = Post::factory()
            ->for($user, 'author')
            ->state(['status' => 'draft'])
            ->create();

        $publishedPosts = Post::published()->get();

        $this->assertTrue($publishedPosts->contains($publishedPost));
        $this->assertFalse($publishedPosts->contains($draftPost));
    }

    /**
     * Tests from Post model mutators.
     */
    public function testTitleMutatorSetsSlugCorrectly(): void
    {
        $user = User::factory()->create();

        $post = Post::factory()
            ->for($user, 'author')
            ->create([
                'title' => 'Sample Post Title'
            ]);

        $this->assertEquals('sample-post-title', $post->slug);
    }
}
