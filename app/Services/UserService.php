<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    protected $cacheDuration = 1800; // 30 minutes

    /**
     * Get cached active users count
     */
    public function getActiveUsersCount()
    {
        return Cache::remember('active_users_count', $this->cacheDuration, function () {
            return User::where('status', 'active')->count();
        });
    }

    /**
     * Get cached roles list
     */
    public function getRoles()
    {
        return Cache::remember('roles_list', 3600, function () {
            return Role::where('status', 'active')->pluck('name', 'id');
        });
    }

    /**
     * Get cached permissions list
     */
    public function getPermissions()
    {
        return Cache::remember('permissions_list', 3600, function () {
            return Permission::select('id', 'name', 'module', 'action')->get();
        });
    }

    /**
     * Get cached user by ID
     */
    public function getUserById($userId)
    {
        return Cache::remember('user_' . $userId, $this->cacheDuration, function () use ($userId) {
            return User::find($userId);
        });
    }

    /**
     * Get cached users with roles
     */
    public function getUsersWithRoles()
    {
        return Cache::remember('users_with_roles', $this->cacheDuration, function () {
            return User::with('role')->get();
        });
    }

    /**
     * Clear user cache
     */
    public function clearUserCache($userId = null)
    {
        if ($userId) {
            Cache::forget('user_' . $userId);
        }
        Cache::forget('active_users_count');
        Cache::forget('users_with_roles');
    }

    /**
     * Clear roles cache
     */
    public function clearRolesCache()
    {
        Cache::forget('roles_list');
    }

    /**
     * Clear permissions cache
     */
    public function clearPermissionsCache()
    {
        Cache::forget('permissions_list');
    }

    /**
     * Create a new user
     */
    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'contact' => $data['contact'] ?? null,
            'dob' => $data['dob'] ?? null,
            'role_id' => $data['role_id'] ?? null,
            'role' => $data['role'] ?? 'user',
            'status' => $data['status'] ?? 'active',
        ]);
    }

    /**
     * Update user
     */
    public function updateUser(User $user, array $data)
    {
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->contact = $data['contact'] ?? $user->contact;
        $user->dob = $data['dob'] ?? $user->dob;
        $user->role_id = $data['role_id'] ?? $user->role_id;
        $user->role = $data['role'] ?? $user->role;
        $user->status = $data['status'] ?? $user->status;

        if (isset($data['password']) && ! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return $user;
    }

    /**
     * Handle user photo upload
     */
    public function handleUserPhotoUpload($photo, User $user)
    {
        if ($photo) {
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            Storage::disk('photos')->putFileAs('', $photo, $filename);
            $user->photo = $filename;
            $user->save();
        }
    }

    /**
     * Assign role permissions to user
     */
    public function assignRolePermissions(User $user, $roleId)
    {
        if ($roleId) {
            $role = Role::find($roleId);
            if ($role && $role->isActive()) {
                // Sync role permissions
                $user->permissions()->sync($role->permissions->pluck('id'));
            }
        }
    }

    /**
     * Assign additional permissions to user
     */
    public function assignAdditionalPermissions(User $user, array $permissions = null, $roleId = null)
    {
        // Assign additional permissions if provided
        if ($permissions && is_array($permissions)) {
            // Get permission IDs based on the permission strings
            $permissionIds = [];
            foreach ($permissions as $permissionString) {
                // Split the permission string (e.g., "land-jamin-view" -> ["land-jamin", "view"])
                $parts = explode('-', $permissionString, 2);
                if (count($parts) == 2) {
                    $module = $parts[0];
                    $action = $parts[1];

                    // Handle special case for modules with hyphens
                    if (count($parts) > 2) {
                        $action = $parts[count($parts) - 1];
                        $module = implode('-', array_slice($parts, 0, count($parts) - 1));
                    }

                    // Create or get the permission
                    $permission = Permission::firstOrCreate([
                        'module' => $module,
                        'action' => $action,
                        'name' => $module . '-' . $action,
                    ]);

                    $permissionIds[] = $permission->id;
                }
            }

            // Merge with role permissions if role_id is provided
            if ($roleId) {
                $role = Role::find($roleId);
                if ($role && $role->isActive()) {
                    $rolePermissionIds = $role->permissions->pluck('id')->toArray();
                    $permissionIds = array_unique(array_merge($rolePermissionIds, $permissionIds));
                }
            }

            $user->permissions()->sync($permissionIds);
        } elseif (! $roleId) {
            // If no role_id and no permissions, clear user permissions
            $user->permissions()->detach();
        }
    }

    /**
     * Toggle user status
     */
    public function toggleUserStatus(User $user, $currentUserId)
    {
        // Prevent users from deactivating their own account
        if ($currentUserId == $user->id && $user->status == 'active') {
            throw new \Exception('You cannot deactivate your own account.');
        }

        // Toggle status
        $user->status = $user->status == 'active' ? 'inactive' : 'active';
        $user->save();

        return $user;
    }

    /**
     * Get status text with styling
     */
    public function getStatusText($status)
    {
        switch ($status) {
            case 'active':
                return '<span class="text-success fw-bold">Active</span>';
            case 'inactive':
                return '<span class="text-secondary fw-bold">Inactive</span>';
            case 'urgent':
                return '<span class="text-danger fw-bold">Urgent</span>';
            case 'under_offer':
                return '<span class="text-warning fw-bold">Under Offer</span>';
            case 'reserved':
                return '<span class="text-info fw-bold">Reserved</span>';
            case 'sold':
                return '<span class="text-muted fw-bold">Sold</span>';
            case 'cancelled':
                return '<span class="text-dark fw-bold">Cancelled</span>';
            case 'coming_soon':
                return '<span class="text-primary fw-bold">Coming Soon</span>';
            case 'price_reduced':
                return '<span class="text-orange fw-bold">Price Reduced</span>';
            default:
                return '<span class="text-secondary fw-bold">' . ucfirst($status) . '</span>';
        }
    }
}
