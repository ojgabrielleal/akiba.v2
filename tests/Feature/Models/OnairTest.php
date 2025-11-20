<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Show;
use App\Models\Onair;

class OnairTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsTheShowOnReturn(): void
    {
        $user = User::factory()->create();
        $show = Show::factory()->for($user)->create();
        $onair = Onair::factory()->create([
            'show_id' => $show->id,
            'show_type' => Show::class
        ]);

        $this->assertInstanceOf(Show::class, $onair->show->first());
    }
}
