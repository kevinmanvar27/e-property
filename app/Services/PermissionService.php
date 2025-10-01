<?php

namespace App\Services;

use App\Models\User;
use App\Models\Permission;
use App\Models\Role;

class PermissionService
{
    /**
     * Assign permissions to user
     */
    public function assignPermissionsToUser(User $user, $roleId = null, array $permissions = null)
    {
        // If a role is assigned, get its permissions
        $permissionIds = [];
        if ($roleId) {
            $role = Role::find($roleId);
            if ($role && $role->isActive()) {
                $permissionIds = $role->permissions->pluck('id')->toArray();
            }
        }
        
        // Merge with additional permissions
        if ($permissions) {
            $permissionIds = array_unique(array_merge($permissionIds, $permissions));
        }
        
        // Sync user permissions
        $user->permissions()->sync($permissionIds);
    }
    
    /**
     * Get all permissions grouped by module
     */
    public function getPermissionsGroupedByModule()
    {
        $permissions = Permission::all();
        $grouped = [];
        
        foreach ($permissions as $permission) {
            if (!isset($grouped[$permission->module])) {
                $grouped[$permission->module] = [
                    'name' => $this->getModuleName($permission->module),
                    'permissions' => []
                ];
            }
            
            $grouped[$permission->module]['permissions'][] = $permission;
        }
        
        return $grouped;
    }
    
    /**
     * Get module name for display
     */
    protected function getModuleName($moduleKey)
    {
        $modules = [
            'land-jamin' => 'Land/Jamin',
            'plot' => 'Plot',
            'shad' => 'Shad',
            'shop' => 'Shop',
            'house' => 'House',
            'amenities' => 'Amenities',
            'land-types' => 'Land Types',
            'countries' => 'Countries',
            'states' => 'States',
            'districts' => 'Districts',
            'cities' => 'Cities/Talukas',
            'settings' => 'Settings',
            'users-management' => 'Management Users',
            'users-regular' => 'Regular Users',
            'roles' => 'Roles',
            'permissions' => 'Permissions'
        ];
        
        return $modules[$moduleKey] ?? ucfirst(str_replace('-', ' ', $moduleKey));
    }
    
    /**
     * Check if user has permission
     */
    public function userHasPermission(User $user, $module, $action)
    {
        // Super admins have all permissions
        if ($user->isSuperAdmin()) {
            return true;
        }
        
        // Check if user has the specific permission
        return $user->hasPermission($module, $action);
    }
}