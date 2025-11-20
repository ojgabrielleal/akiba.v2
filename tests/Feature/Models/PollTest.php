<?php

namespace Tests\Feature\Models;

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
        $poll = Poll::factory()->create();
        PollOption::factory()->count(3)->create([
            'poll_id' => $poll->id
        ]);

        $this->assertInstanceOf(PollOption::class, $poll->pollOption->first());
    }
}
