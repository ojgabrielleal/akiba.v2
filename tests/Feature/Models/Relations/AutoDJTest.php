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

        $autoDJ = AutoDJ::factory()
            ->for($user, 'host')
            ->create();

        $this->assertTrue($autoDJ->host->is($user));
    }

    public function testContainsThePhrasesOnReturn(): void
    {
        $user = User::factory()->create();
        $phrases = AutoDJPhrase::factory()->count(5);

        $autoDJ = AutoDJ::factory()
            ->for($user, 'host')
            ->has($phrases, 'phrases')
            ->create();

        $this->assertCount(5, $autoDJ->phrases);
        $this->assertContainsOnlyInstancesOf(
            AutoDJPhrase::class, 
            $autoDJ->phrases
        );
    }

}

