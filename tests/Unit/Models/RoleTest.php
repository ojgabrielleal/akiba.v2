<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Permission;
use App\Models\Role;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests from Role model relationships.
     */
    public function testPermissionsRelationshipReturnsPermissions(): void
    {
        $permission = Permission::factory()->count(3);
        $role = Role::factory()
            ->hasAttached($permission, [], 'permissions')
            ->create();

        $this->assertCount(3, $role->permissions);
        $this->assertContainsOnlyInstancesOf(
            Permission::class,
            $role->permissions
        );
    }
}
