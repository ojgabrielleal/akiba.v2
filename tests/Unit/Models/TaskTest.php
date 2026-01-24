<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase; 
    
    public function testResponsibleRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $task = Task::factory()
            ->for($user, 'responsible')
            ->create();

        $this->assertTrue($task->responsible->is($user));
    }
}
