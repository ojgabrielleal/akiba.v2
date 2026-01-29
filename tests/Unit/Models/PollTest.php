<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Poll;
use App\Models\PollOption;

class PollTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Poll model relationships.
     */
    public function testOptionsRelationshipReturnsPollOptions(): void
    {
        $options = PollOption::factory()->count(3);

        $poll = Poll::factory()
            ->has($options, 'options')
            ->create();

        $this->assertCount(3, $poll->options);
        $this->assertContainsOnlyInstancesOf(
            PollOption::class,
            $poll->options
        );
    }

    /**
     * Tests from Poll model scopes.
     */
    public function testScopeActiveReturnsOnlyActivePolls(): void
    {
        $activePoll = Poll::factory()
            ->create(['is_active' => true]);

        $inactivePoll = Poll::factory()
            ->create(['is_active' => false]);

        $polls = Poll::active()->get();

        $this->assertTrue($polls->contains($activePoll));
        $this->assertFalse($polls->contains($inactivePoll));
    }
}
