<?php

namespace Tests\Feature\Models\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Poll;
use App\Models\PollOption;

class PollTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsPollsOptionsOnReturn(): void
    {
        $poll = Poll::factory()->has(PollOption::factory()->count(3), 'pollOption')->create();

        $this->assertInstanceOf(PollOption::class, $poll->pollOption->first());
    }
}
