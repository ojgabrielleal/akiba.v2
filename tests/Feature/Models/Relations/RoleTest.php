<?php

namespace Tests\Feature\Models\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Permission;
use App\Models\Role;

class RoleTest extends TestCase
{
    use RefreshDatabase;
    
    public function testContainsPermissionsOnReturn(): void
    {
        $role = Role::factory()->hasAttached(Permission::factory()->count(3), [], 'permissions')->create();

        $this->assertInstanceOf(Permission::class, $role->permissions->first());
        $this->assertCount(3, $role->permissions);
    }
}
