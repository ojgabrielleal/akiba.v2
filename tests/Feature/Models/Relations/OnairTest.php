<?php

namespace Tests\Feature\Models\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Program;
use App\Models\Onair;

class OnairTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsTheShowOnReturn(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->for($user)->create();
        $onair = Onair::factory()->create([
            'program_id' => $program->id,
            'program_type' => Program::class
        ]);

        $this->assertInstanceOf(Program::class, $onair->program);
    }
}
