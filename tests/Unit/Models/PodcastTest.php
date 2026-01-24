<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Podcast;

class PodcastTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $podcast = Podcast::factory()
            ->for($user, 'author')
            ->create();

        $this->assertTrue($podcast->author->is($user));
    }
}
