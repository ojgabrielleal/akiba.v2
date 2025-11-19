<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityConfirmation;

class ActivityConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsTheUserOnReturn(): void
    {
        $user = User::factory()->create();
        $activity = Activity::factory()->for($user)->create();

        $activityConfirmation = ActivityConfirmation::factory()->for($user)->create([
            'activity_id' => $activity->id,
        ]);

        $this->assertInstanceOf(User::class, $activityConfirmation->user);
    }
}
