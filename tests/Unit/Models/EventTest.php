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
    
    public function testAuthorRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $event = Event::factory()
            ->for($user, 'author')
            ->create();

        $this->assertTrue($event->author->is($user));
    }
}
