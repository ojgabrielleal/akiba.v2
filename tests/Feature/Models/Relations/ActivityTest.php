<?php

namespace Tests\Feature\Models\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityConfirmation;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsTheUserOnReturn(): void
    {
        $user = User::factory()->create();
        $activity = Activity::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $activity->user->first());
    }
    
    public function testContainsTheConfirmationsOnReturn(): void
    {
        $user = User::factory()->create();
        $activity = Activity::factory()->for($user)->has(ActivityConfirmation::factory()->for($user)->count(5), 'activityConfirmation')->create();

        $this->assertInstanceOf(ActivityConfirmation::class, $activity->activityConfirmation->first());
        $this->assertCount(5, $activity->activityConfirmation);
    }
}
