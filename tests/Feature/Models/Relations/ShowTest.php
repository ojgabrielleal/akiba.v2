<?php

namespace Tests\Feature\Models\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Show;
use App\Models\ShowSchedule;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsTheUserOnReturn(): void
    {
        $user = User::factory()->create();
        $show = Show::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $show->user->first());
    }

    public function testContainsTheShowSchedulesOnReturn(): void 
    {
        $user = User::factory()->create();
        $show = Show::factory()->for($user)->has(ShowSchedule::factory()->count(3), 'showSchedule')->create();

        $this->assertInstanceOf(ShowSchedule::class, $show->showSchedule->first());
        $this->assertCount(3, $show->showSchedule);
    }
}
