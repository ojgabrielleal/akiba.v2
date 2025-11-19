<?php

namespace Tests\Feature\Models;

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
        $activity = Activity::factory()->for($user)->create();

        ActivityConfirmation::factory()->count(5)->for($user)->create([
            'activity_id' => $activity->id,
        ]);

        $this->assertInstanceOf(ActivityConfirmation::class, $activity->activityConfirmations->first());
        $this->assertCount(5, $activity->activityConfirmations);
    }
}
