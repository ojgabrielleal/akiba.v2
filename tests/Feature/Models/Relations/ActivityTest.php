<?php

namespace Tests\Feature\Models\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityParticipants;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsTheUserOnReturn(): void
    {
        $user = User::factory()->create();

        $activity = Activity::factory()
            ->for($user, 'responsible')
            ->create();

        $this->assertTrue($activity->responsible->is($user));
    }

    public function testContainsTheConfirmationsOnReturn(): void
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
