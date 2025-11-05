<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserPermissionController extends Controller
{
    /**
     * Show the permissions management view for a user
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::with(['permissions', 'role'])->findOrFail($id);
        $permissions = Permission::all();
        $roles = Role::where('status', 'active')->get();

        return view('admin.users.permissions', compact('user', 'permissions', 'roles'));
    }

    /**
     * Assign permissions to a user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role_id' => 'nullable|exists:roles,id',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Update user's role_id
        $user->role_id = $request->role_id;
        $user->save();

        // If a role is assigned, get its permissions
        $permissionIds = [];
        if ($request->role_id) {
            $role = Role::find($request->role_id);
            if ($role && $role->isActive()) {
                $permissionIds = $role->permissions->pluck('id')->toArray();
            }
        }

        // Merge with additional permissions
        if ($request->has('permissions')) {
            $permissionIds = array_unique(array_merge($permissionIds, $request->permissions));
        }

        // Sync user permissions
        $user->permissions()->sync($permissionIds);

        return redirect()->back()->with('success', 'User permissions updated successfully.');
    }

    /**
     * Get user permissions and photo for editing
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserPermissions($id)
    {
        $user = User::with(['permissions', 'role'])->findOrFail($id);
        
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'contact' => $user->contact,
                'photo' => $user->photo,
                'dob' => $user->dob,
                'role' => $user->role,
                'role_id' => $user->role_id,
                'status' => $user->status,
            ],
            'permissions' => $user->permissions
        ]);
    }
}