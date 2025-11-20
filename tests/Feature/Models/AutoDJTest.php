<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\AutoDJ;
use App\Models\AutoDJPhrase;

class AutoDJTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsTheUserOnReturn(): void
    {
        $user = User::factory()->create();
        $autoDJ = AutoDJ::factory()->for($user)->create();

        $this->assertInstanceOf(User::class, $autoDJ->user->first());
    }

    public function testContainsThePhrasesOnReturn(): void
    {
        $user = User::factory()->create();
        $autoDJ = AutoDJ::factory()->for($user)->create();

        AutoDJPhrase::factory()->count(5)->create([
            'autodj_id' => $autoDJ->id,
        ]);

        $this->assertInstanceOf(AutoDJPhrase::class, $autoDJ->autoDJPhrase->first());
        $this->assertCount(5, $autoDJ->autoDJPhrase);
    }

}

