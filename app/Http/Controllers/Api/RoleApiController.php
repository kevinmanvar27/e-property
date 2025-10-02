<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleApiController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        try {
            $roles = Role::with('permissions')->get();

            return response()->json([
                'success' => true,
                'data' => $roles,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading roles: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading roles. Please try again.',
            ], 500);
        }
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'display_name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $role = Role::create($request->only(['name', 'display_name', 'description']));

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully',
                'data' => $role,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating role: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the role. Please try again.',
            ], 500);
        }
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        try {
            $role->load('permissions');

            return response()->json([
                'success' => true,
                'data' => $role,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading role: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading the role. Please try again.',
            ], 500);
        }
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
                'display_name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $role->update($request->only(['name', 'display_name', 'description']));

            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully',
                'data' => $role,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating role: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the role. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        try {
            // Prevent deletion of default roles
            if (in_array($role->name, ['admin', 'super_admin', 'regular_user'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete default roles.',
                ], 400);
            }

            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting role: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the role. Please try again.',
            ], 500);
        }
    }

    /**
     * Get permissions for a specific role.
     */
    public function getRolePermissions(Role $role)
    {
        try {
            $permissions = $role->permissions;

            return response()->json([
                'success' => true,
                'data' => $permissions,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading role permissions: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading role permissions. Please try again.',
            ], 500);
        }
    }

    /**
     * Assign permissions to a role.
     */
    public function assignPermissions(Request $request, Role $role)
    {
        try {
            $request->validate([
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            $role->permissions()->sync($request->permissions);

            return response()->json([
                'success' => true,
                'message' => 'Permissions assigned successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error assigning permissions to role: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while assigning permissions. Please try again.',
            ], 500);
        }
    }
}
