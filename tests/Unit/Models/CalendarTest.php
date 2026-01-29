<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Activity;
use App\Models\Calendar;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Calendar model relationships.
     */
    public function testResponsibleRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $calendar = Calendar::factory()
            ->for($user, 'responsible')
            ->create();

        $this->assertTrue($calendar->responsible->is($user));
    }

    public function testActivityRelationshipReturnsActivity(): void
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

    /**
    * Tests from Calendar model scopes.
    */
    public function testActiveScopeReturnsOnlyActiveCalendars(): void
    {
        $user = User::factory()->create();

        $calendarActive = Calendar::factory()
            ->for($user, 'responsible')
            ->create(['is_active' => true]);

        $calendarInatictive = Calendar::factory()
            ->for($user, 'responsible')
            ->create(['is_active' => false]);

        $calendar = Calendar::active()->get();

        $this->assertTrue($calendar->contains($calendarActive));
        $this->assertFalse($calendar->contains($calendarInatictive));
    }
}
