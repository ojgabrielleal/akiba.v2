<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Podcast;

class PodcastTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Podcast model relationships.
     */
    public function testAuthorRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $podcast = Podcast::factory()
            ->for($user, 'author')
            ->create();

        $this->assertTrue($podcast->author->is($user));
    }

    /**
     * Tests from Podcast model scopes.
     */
    public function testScopeActiveReturnsOnlyActivePodcasts(): void
    {
        $user = User::factory()->create();

        $activePodcast = Podcast::factory()
            ->for($user, 'author')
            ->create(['is_active' => true]);

        $inactivePodcast = Podcast::factory()
            ->for($user, 'author')
            ->create(['is_active' => false]);

        $podcasts = Podcast::active()->get();

        $this->assertTrue($podcasts->contains($activePodcast));
        $this->assertFalse($podcasts->contains($inactivePodcast));
    }

    /**
     * Tests from Podcast model mutators.
     */
    public function testTitleMutatorSetsSlugCorrectly(): void
    {
        $user = User::factory()->create();

        $podcast = Podcast::factory()
            ->for($user, 'author')
            ->create([
                'title' => 'Sample Podcast Title'
            ]);

        $this->assertEquals('sample-podcast-title', $podcast->slug);
    }
}
