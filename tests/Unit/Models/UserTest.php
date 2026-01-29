<?php

namespace Tests\Unit\Models;

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

    /**
     * Tests from User model relationships.
     */
    public function testPreferencesRelationshipReturnsUserPreferences(): void
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

    public function testSocialsRelationshipReturnsUserSocials(): void
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

    public function testRolesRelationshipReturnsRoles(): void
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

    /**
     * Tests from User model scopes.
     */
    public function testScopeActiveReturnsOnlyActiveUsers(): void
    {
        $activeUser = User::factory()->create(['is_active' => true]);
        $inactiveUser = User::factory()->create(['is_active' => false]);

        $users = User::active()->get();

        $this->assertTrue($users->contains($activeUser));
        $this->assertFalse($users->contains($inactiveUser));
    }
}
