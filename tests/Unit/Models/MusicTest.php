<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Music;

class MusicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Music model scopes.
     */
    public function testScopeRankingReturnsOnlyRankedMusics(): void
    {
        $rankedMusic = Music::factory()->create(['in_ranking' => true]);
        $notRankedMusic = Music::factory()->create(['in_ranking' => false]);

        $musics = Music::ranking()->get();

        $this->assertTrue($musics->contains($rankedMusic));
        $this->assertFalse($musics->contains($notRankedMusic));
    }
}
