<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserPermissionApiController extends Controller
{
    /**
     * Display user permissions.
     */
    public function show(User $user)
    {
        try {
            $permissions = $user->permissions;

            return response()->json([
                'success' => true,
                'data' => $permissions,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading user permissions: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading user permissions. Please try again.',
            ], 500);
        }
    }

    /**
     * Assign permissions to user.
     */
    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            $user->permissions()->sync($request->permissions);

            return response()->json([
                'success' => true,
                'message' => 'User permissions updated successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating user permissions: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating user permissions. Please try again.',
            ], 500);
        }
    }
}
