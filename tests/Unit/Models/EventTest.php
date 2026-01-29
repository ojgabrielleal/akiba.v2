<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Event;

class EventTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Event model relationships.
     */
    public function testAuthorRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $event = Event::factory()
            ->for($user, 'author')
            ->create();

        $this->assertTrue($event->author->is($user));
    }

    /**
     * Tests from Event model scopes.
     */
    public function testActiveScopeReturnsOnlyActiveEvents(): void
    {
        $user = User::factory()->create();

        $activeEvents = Event::factory()
            ->for($user, 'author')
            ->create(['is_active' => true]);

        $inactiveEvents = Event::factory()
            ->for($user, 'author')
            ->create(['is_active' => false]);

        $events = Event::active()->get();

        $this->assertTrue($events->contains($activeEvents));
        $this->assertFalse($events->contains($inactiveEvents));
    }
}
