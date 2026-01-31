<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityParticipants;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Activity model relationships.
     */
    public function testAuthorRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $activity = Activity::factory()
            ->for($user, 'author')
            ->create();

        $this->assertTrue($activity->author->is($user));
    }

    public function testConfirmerRelationshipReturnsUsers(): void
    {
        $user = User::factory()->create();
        $confirmers = ActivityParticipants::factory()->for($user, 'confirmer')->count(5);

        $activity = Activity::factory()
            ->for($user, 'author')
            ->has($confirmers, 'confirmations')
            ->create();

        $this->assertCount(5, $activity->confirmations);
        $this->assertContainsOnlyInstancesOf(
            ActivityParticipants::class,
            $activity->confirmations
        );
    }

    /**
     * Tests from Activity model scopes.
     */
    public function testScopeValidReturnsOnlyValidActivities(): void
    {
        $user = User::factory()->create();

        $validActivity = Activity::factory()
            ->for($user, 'author')
            ->create(['limit' => now()->subDays(3)]);

        $expiredActivity = Activity::factory()
            ->for($user, 'author')
            ->create(['limit' => now()->addDays(3)]);

        $activities = Activity::valid()->get();

        $this->assertTrue($activities->contains($validActivity));
        $this->assertFalse($activities->contains($expiredActivity));
    }
}
