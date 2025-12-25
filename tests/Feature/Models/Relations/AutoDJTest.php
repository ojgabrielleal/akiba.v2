<?php

namespace Tests\Feature\Models\Relations;

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

        $this->assertInstanceOf(User::class, $autoDJ->host);
    }

    public function testContainsThePhrasesOnReturn(): void
    {
        $user = User::factory()->create();
        $autoDJ = AutoDJ::factory()->for($user)->has(AutoDJPhrase::factory()->count(5), 'phrases')->create();

        $this->assertInstanceOf(AutoDJPhrase::class, $autoDJ->phrases->first());
        $this->assertCount(5, $autoDJ->phrases);
    }

}

