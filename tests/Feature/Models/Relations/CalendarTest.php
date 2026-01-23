<?php

namespace Tests\Feature\Models\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Activity;
use App\Models\Calendar;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsTheUserOnReturn(): void
    {
        $user = User::factory()->create();

        $calendar = Calendar::factory()
            ->for($user, 'responsible')
            ->create();

        $this->assertTrue($calendar->responsible->is($user));
    }

    public function testContainsTheActivityOnReturn(): void
    {
        $user = User::factory()->create();

        $activity = Activity::factory()
            ->for($user, 'responsible')
            ->create();

        $calendar = Calendar::factory()
            ->for($user, 'responsible')
            ->for($activity, 'activity')
            ->create();

        $this->assertTrue($calendar->activity->is($activity));
    }
}
