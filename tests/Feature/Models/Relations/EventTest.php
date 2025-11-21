<?php

namespace Tests\Feature\Models\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Event;

class EventTest extends TestCase
{
    use RefreshDatabase;
    
    public function testContainsTheUserOnReturn(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $event->user->first());
    }
}
