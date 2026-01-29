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

        $onair = Onair::factory()->create([
            'program_id' => $program->id,
            'program_type' => Program::class
        ]);

        $music = Music::factory()->create();

        SongRequest::factory()->count(5)->create([
            'onair_id' => $onair->id,
            'music_id' => $music->id,
            'name' => 'John Doe',
            'address' => '123 Main St',
            'is_played' => true,
        ]);

        $mostActiveListenerArray = ListenerMonth::mostActiveListenerOfCurrentMonth();
        $mostActiveListener = $mostActiveListenerArray[0] ?? null; 

        $this->assertNotNull($mostActiveListener);
        $this->assertEquals('John Doe', $mostActiveListener->listener_name);
        $this->assertEquals('123 Main St', $mostActiveListener->address ?? ''); 
        $this->assertEquals($program->name, $mostActiveListener->favorite_program);
        $this->assertEquals(5, $mostActiveListener->total_requests);
    }
}
