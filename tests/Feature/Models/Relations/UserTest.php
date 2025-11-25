<?php

namespace Tests\Feature\Models\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\UserPreference;
use App\Models\UserSocial;
use App\Models\Role;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testContainsThePreferencesOnReturn(): void
    {
        $user = User::factory()->has(UserPreference::factory(), 'preferences')->create();

        $this->assertInstanceOf(UserPreference::class, $user->preferences->first());
    }

    public function testContainsTheSocialsOnReturn(): void
    {
        $user = User::factory()->has(UserSocial::factory(), 'socials')->create();

        $this->assertInstanceOf(UserSocial::class, $user->socials->first());
    }

    public function testContainsTheRolesOnReturn(): void
    {
        $user = User::factory()->hasAttached(Role::factory()->count(3), [], 'roles')->create();

        $this->assertInstanceOf(Role::class, $user->roles->first());
    }
}
