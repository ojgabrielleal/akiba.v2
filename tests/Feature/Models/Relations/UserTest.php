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

    public function testContainsTheUserPreferenceOnReturn(): void
    {
        $user = User::factory()->has(UserPreference::factory(), 'userPreference')->create();

        $this->assertInstanceOf(UserPreference::class, $user->userPreference->first());
    }

    public function testContainsTheUserSocialOnReturn(): void
    {
        $user = User::factory()->has(UserSocial::factory(), 'userSocial')->create();

        $this->assertInstanceOf(UserSocial::class, $user->userSocial->first());
    }

    public function testContainsTheRoleOnReturn(): void
    {
        $user = User::factory()->hasAttached(Role::factory()->count(3), [], 'role')->create();

        $this->assertInstanceOf(Role::class, $user->role->first());
    }
}
