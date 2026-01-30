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

    /**
     * Tests from Program model relationships.
     */
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

    /**
     * Tests from Program model scopes.
     */
    public function testScopeActiveReturnsOnlyActivePrograms(): void
    {
        $user = User::factory()->create();

        $activeProgram = Program::factory()
            ->for($user, 'host')
            ->create(['is_active' => true]);

        $inactiveProgram = Program::factory()
            ->for($user, 'host')
            ->create(['is_active' => false]);

        $activePrograms = Program::active()->get();

        $this->assertTrue($activePrograms->contains($activeProgram));
        $this->assertFalse($activePrograms->contains($inactiveProgram));
    }

    /**
     * Tests from Post model mutators.
     */
    public function testNameMutatorSetsSlugCorrectly(): void
    {
        $user = User::factory()->create();

        $program = Program::factory()
            ->for($user, 'host')
            ->create([
                'name' => 'Sample Program Title'
            ]);

        $this->assertEquals('sample-program-title', $program->slug);
    }
}
