<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Program;
use App\Models\Onair;
use App\Models\Music;
use App\Models\SongRequest;

class SongRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from SongRequest model scopes.
     */
    public function testScopePlayedReturnsOnlyPlayedSongRequests(): void
    {
        $user = User::factory()->create();

        $program = Program::factory()
            ->for($user, 'host')
            ->create();

        $onair = Onair::factory()
            ->for($program, 'program')
            ->create();

        $music = Music::factory()
            ->create();

        $playedRequest = SongRequest::factory()
            ->for($onair, 'onair')
            ->for($music, 'music')
            ->create(['is_played' => true]);

        $queuedRequest = SongRequest::factory()
            ->for($onair, 'onair')
            ->for($music, 'music')
            ->create(['is_played' => false]);

        $playedRequests = SongRequest::played()->get();

        $this->assertTrue($playedRequests->contains($playedRequest));
        $this->assertFalse($playedRequests->contains($queuedRequest));
    }
}
