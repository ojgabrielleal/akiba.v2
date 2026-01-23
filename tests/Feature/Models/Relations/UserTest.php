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
        $preference = UserPreference::factory();

        $user = User::factory()
            ->has($preference, 'preferences')
            ->create();

        $this->assertContainsOnlyInstancesOf(
            UserPreference::class,
             $user->preferences
        );
    }

    public function testContainsTheSocialsOnReturn(): void
    {
        $social = UserSocial::factory();

        $user = User::factory()
            ->has($social, 'socials')
            ->create();

        $this->assertContainsOnlyInstancesOf(
            UserSocial::class,
            $user->socials
        );
    }

    public function testContainsTheRolesOnReturn(): void
    {
        $role = Role::factory();
        
        $user = User::factory()
            ->hasAttached($role, [], 'roles')
            ->create();

        $this->assertContainsOnlyInstancesOf(
            Role::class,
            $user->roles
        );
    }
}
