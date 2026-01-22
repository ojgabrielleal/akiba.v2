<?php

namespace Tests\Feature\Models\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Program;
use App\Models\ProgramSchedule;

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsTheUserOnReturn(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $program->user);
    }

    public function testContainsTheSchedulesOnReturn(): void 
    {
        $user = User::factory()->create();
        $program = Program::factory()->for($user)->has(ProgramSchedule::factory()->count(3), 'schedules')->create();

        $this->assertInstanceOf(ProgramSchedule::class, $program->schedules->first());
        $this->assertCount(3, $program->schedules);
    }
}
