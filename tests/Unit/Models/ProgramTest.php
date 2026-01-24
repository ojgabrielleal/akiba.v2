<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Program;
use App\Models\ProgramSchedule;

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    public function testHostRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $program = Program::factory()
            ->for($user, 'host')
            ->create();

        $this->assertTrue($program->host->is($user));
    }

    public function testSchedulesRelationshipReturnsProgramSchedules(): void 
    {
        $user = User::factory()->create();
        $schedules = ProgramSchedule::factory()->count(3);

        $program = Program::factory()
            ->for($user, 'host')
            ->has($schedules, 'schedules')
            ->create();

        $this->assertCount(3, $program->schedules);
        $this->assertContainsOnlyInstancesOf(
            ProgramSchedule::class, 
            $program->schedules
        );
    }
}
