<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionApiController extends Controller
{
    /**
     * Display a listing of permissions.
     */
    public function index()
    {
        try {
            $permissions = Permission::all();

            return response()->json([
                'success' => true,
                'data' => $permissions,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading permissions: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading permissions. Please try again.',
            ], 500);
        }
    }

    /**
     * Store a newly created permission.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:permissions,name',
                'display_name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $permission = Permission::create($request->only(['name', 'display_name', 'description']));

            return response()->json([
                'success' => true,
                'message' => 'Permission created successfully',
                'data' => $permission,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating permission: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the permission. Please try again.',
            ], 500);
        }
    }

    /**
     * Display the specified permission.
     */
    public function show(Permission $permission)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $permission,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading permission: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading the permission. Please try again.',
            ], 500);
        }
    }

    /**
     * Update the specified permission.
     */
    public function update(Request $request, Permission $permission)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
                'display_name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $permission->update($request->only(['name', 'display_name', 'description']));

            return response()->json([
                'success' => true,
                'message' => 'Permission updated successfully',
                'data' => $permission,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating permission: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the permission. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified permission.
     */
    public function destroy(Permission $permission)
    {
        try {
            // Prevent deletion of default permissions
            $defaultPermissions = [
                'view-dashboard',
                'manage-users',
                'manage-properties',
                'manage-settings',
                'manage-roles',
                'manage-permissions',
            ];

            if (in_array($permission->name, $defaultPermissions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete default permissions.',
                ], 400);
            }

            $permission->delete();

            return response()->json([
                'success' => true,
                'message' => 'Permission deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting permission: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the permission. Please try again.',
            ], 500);
        }
    }
}
