<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Program;
use App\Models\Onair;
use App\Models\SongRequest;
use App\Models\Music;
use App\Models\ListenerMonth;

class ListenerMonthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Event model static methods.
     */
    public function testMethodMostActiveListenerReturnsOnlyMostActiveListener(): void
    {
        $user = User::factory()->create();

        $program = Program::factory()
            ->for($user, 'host')
            ->create();

        $onair = Onair::factory()
            ->for($program, 'program')
            ->create();

        $music = Music::factory()->create();

        SongRequest::factory()->count(5)->create([
            'onair_id' => $onair->id,
            'music_id' => $music->id,
            'name' => 'John Doe',
            'address' => '123 Main St',
            'was_reproduced' => true,
        ]);

        $mostActiveListenerArray = ListenerMonth::mostActiveListenerOfCurrentMonth();
        $mostActiveListener = $mostActiveListenerArray[0] ?? null;

        $this->assertNotNull($mostActiveListener);
        $this->assertEquals('John Doe', $mostActiveListener->listener_name);
        $this->assertEquals('123 Main St', $mostActiveListener->address ?? '');
        $this->assertEquals($program->name, $mostActiveListener->favorite_program);
        $this->assertEquals(5, $mostActiveListener->total_requests);
    }

    /**
     * Tests from ListenerMonth model static methods.
     */
    public function testMethodMostActiveListenerReturnsCorrectData(): void
    {
        $user = User::factory()->create();
        $program = Program::factory()->for($user, 'host')->create();

        $onair = Onair::factory()
            ->for($program, 'program')
            ->create();

        $music = Music::factory()->create();

        SongRequest::factory()->count(5)->create([
            'onair_id'   => $onair->id,
            'music_id'   => $music->id,
            'name'       => 'John Doe',
            'address'    => 'Rua das Flores, 123',
            'was_reproduced'  => true,
            'created_at' => now(),
        ]);

        SongRequest::factory()->count(2)->create([
            'onair_id'   => $onair->id,
            'music_id'   => $music->id,
            'name'       => 'Outro Ouvinte',
            'created_at' => now(),
        ]);

        $results = ListenerMonth::mostActiveListenerOfCurrentMonth();
        $mostActive = $results[0] ?? null;

        $this->assertNotNull($mostActive, 'O resultado não deveria ser nulo.');
        $this->assertEquals('John Doe', $mostActive->listener_name);
        $this->assertEquals(5, $mostActive->total_requests);
        $this->assertEquals($program->name, $mostActive->favorite_program);
    }
}
