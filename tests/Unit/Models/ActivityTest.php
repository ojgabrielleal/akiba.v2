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

    public function testResponsibleRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $activity = Activity::factory()
            ->for($user, 'responsible')
            ->create();

        $this->assertTrue($activity->responsible->is($user));
    }

    public function testConfirmerRelationshipReturnsUsers(): void
    {
        $user = User::factory()->create();
        $confirmers = ActivityParticipants::factory()->for($user, 'confirmer')->count(5);

        $activity = Activity::factory()
            ->for($user, 'responsible')
            ->has($confirmers, 'confirmations')
            ->create();

        $this->assertCount(5, $activity->confirmations);
        $this->assertContainsOnlyInstancesOf(
            ActivityParticipants::class, 
            $activity->confirmations
        );
    }
}
