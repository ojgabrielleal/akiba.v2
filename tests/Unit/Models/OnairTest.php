<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Program;
use App\Models\Onair;

class OnairTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Onair model relationships.
     */
    public function testProgramRelationshipReturnsProgram(): void
    {
        $user = User::factory()->create();

        $program = Program::factory()
            ->for($user, 'host')
            ->create();

        $onair = Onair::factory()
            ->for($program, 'program')
            ->create();

        $this->assertTrue($onair->program->is($program));
    }

    /**
     * Tests from Onair model scopes.
     */
    public function testScopeLiveReturnsOnlyLiveOnairs(): void
    {
        $user = User::factory()->create();

        $program = Program::factory()
            ->for($user, 'host')
            ->create();

        $liveOnair = Onair::factory()
            ->for($program, 'program')
            ->create([
                'is_live' => true,
            ]);

        $notLiveOnair = Onair::factory()
            ->for($program, 'program')
            ->create([
                'is_live' => false,
            ]);

        $onairs = Onair::live()->get();

        $this->assertTrue($onairs->contains($liveOnair));
        $this->assertFalse($onairs->contains($notLiveOnair));
    }
}
