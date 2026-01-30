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

    /**
     * Tests from Task model relationships.
     */
    public function testResponsibleRelationshipReturnsUser(): void
    {
        $user = User::factory()->create();

        $task = Task::factory()
            ->for($user, 'responsible')
            ->create();

        $this->assertTrue($task->responsible->is($user));
    }

    /**
     * Tests from Task model scopes.
     */
    public function testScopeActiveReturnsOnlyActiveTasks(): void
    {
        $user = User::factory()->create();

        $activeTask = Task::factory()
            ->for($user, 'responsible')
            ->create(['is_active' => true]);

        $inactiveTask = Task::factory()
            ->for($user, 'responsible')
            ->create(['is_active' => false]);

        $activeTasks = Task::active()->get();

        $this->assertTrue($activeTasks->contains($activeTask));
        $this->assertFalse($activeTasks->contains($inactiveTask));
    }

    public function testScopeIncompletedReturnsOnlyIncompletedTasks(): void
    {
        $user = User::factory()->create();

        $incompletedTask = Task::factory()
            ->for($user, 'responsible')
            ->create(['is_completed' => false]);

        $completedTask = Task::factory()
            ->for($user, 'responsible')
            ->create(['is_completed' => true]);

        $incompletedTasks = Task::incompleted()->get();

        $this->assertTrue($incompletedTasks->contains($incompletedTask));
        $this->assertFalse($incompletedTasks->contains($completedTask));
    }

    public function testScopeMineReturnsOnlyTasksOfAuthenticatedUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $myTask = Task::factory()
            ->for($user, 'responsible')
            ->create();

        $otherTask = Task::factory()
            ->for($otherUser, 'responsible')
            ->create();

        $this->actingAs($user);

        $myTasks = Task::mine()->get();

        $this->assertTrue($myTasks->contains($myTask));
        $this->assertFalse($myTasks->contains($otherTask));
    }

    /**
     * Tests from Task model attributes.
     */
    public function testAttributeIsDueSoonReturnsCorrectValue(): void
    {
        $today = \Carbon\Carbon::parse('2026-01-20');
        \Carbon\Carbon::setTestNow($today);

        $user = User::factory()->create();

        $dueSoonTask = Task::factory()->for($user, 'responsible')->create([
            'deadline' => '2026-01-23',
            'is_completed' => false
        ]);

        $farTask = Task::factory()->for($user, 'responsible')->create([
            'deadline' => '2026-01-30',
            'is_completed' => false
        ]);

        $completedTask = Task::factory()->for($user, 'responsible')->create([
            'deadline' => '2026-01-23',
            'is_completed' => true
        ]);

        $this->assertTrue($dueSoonTask->is_due_soon, 'Tarefa não concluída vencendo em 3 dias deve ser true.');
        $this->assertFalse($farTask->is_due_soon, 'Tarefa vencendo em 10 dias deve ser false.');
        $this->assertFalse($completedTask->is_due_soon, 'Tarefa já concluída deve ser false mesmo se o prazo estiver perto.');

        \Carbon\Carbon::setTestNow();
    }
}
