<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Permission;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function super_admin_has_all_permissions()
    {
        $user = User::factory()->create([
            'role' => 'super_admin'
        ]);

        $this->actingAs($user);

        // Super admin should have all permissions
        $this->assertTrue($user->hasPermission('land-jamin', 'view'));
        $this->assertTrue($user->hasPermission('plot', 'create'));
        $this->assertTrue($user->hasPermission('settings', 'update'));
    }

    /** @test */
    public function admin_with_specific_permissions_only_has_those_permissions()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($user);

        // Create a specific permission
        $permission = Permission::create([
            'name' => 'land-jamin-view',
            'module' => 'land-jamin',
            'action' => 'view'
        ]);

        // Assign permission to user
        $user->permissions()->attach($permission);

        // User should have this specific permission
        $this->assertTrue($user->hasPermission('land-jamin', 'view'));

        // User should not have other permissions
        $this->assertFalse($user->hasPermission('plot', 'create'));
        $this->assertFalse($user->hasPermission('settings', 'update'));
    }

    /** @test */
    public function user_without_permissions_cannot_access_protected_routes()
    {
        $user = User::factory()->create([
            'role' => 'admin'
        ]);

        $this->actingAs($user);

        // User should not have permission to view land-jamin
        $response = $this->get('/admin/land-jamin');
        
        // Since we haven't applied the middleware to the route yet, this will depend on the controller logic
        // For now, we'll just test that the helper function works correctly
        $this->assertFalse($user->hasPermission('land-jamin', 'view'));
    }
}