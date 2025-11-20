<?php

namespace Tests\Feature\Models;

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
        $role = Role::factory()->create();

        Permission::factory()->create([
            'role_id' => $role->id,
        ]);

        $this->assertInstanceOf(Permission::class, $role->permissions->first());
    }
}
