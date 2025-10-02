<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Cache;

class RoleService
{
    protected $cacheDuration = 1800; // 30 minutes

    /**
     * Get cached roles list
     */
    public function getAllRoles()
    {
        return Cache::remember('all_roles', 3600, function () {
            return Role::all();
        });
    }

    /**
     * Get cached active roles
     */
    public function getActiveRoles()
    {
        return Cache::remember('active_roles', 3600, function () {
            return Role::where('status', 'active')->get();
        });
    }

    /**
     * Get cached permissions list
     */
    public function getAllPermissions()
    {
        return Cache::remember('all_permissions', 3600, function () {
            return Permission::all();
        });
    }

    /**
     * Get cached permissions by role
     */
    public function getPermissionsByRole($roleId)
    {
        return Cache::remember('permissions_role_' . $roleId, 3600, function () use ($roleId) {
            $role = Role::find($roleId);
            return $role ? $role->permissions : collect();
        });
    }

    /**
     * Clear role cache
     */
    public function clearCache($key = null)
    {
        if ($key) {
            Cache::forget($key);
        } else {
            Cache::forget('all_roles');
            Cache::forget('active_roles');
            Cache::forget('all_permissions');
        }
    }
}