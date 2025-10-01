<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use App\Services\UserService;
use App\Http\Requests\ManagementUserStoreRequest;
use App\Http\Requests\ManagementUserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagementUserController extends Controller
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * Get available modules for permissions
     *
     * @return array
     */
    private function getAvailableModules()
    {
        return [
            'land-jamin' => 'Land/Jamin',
            'plot' => 'Plot',
            'shad' => 'Shad',
            'shop' => 'Shop',
            'house' => 'House',
            'user' => 'User Management',
            'role' => 'Role Management'
        ];
    }
    
    /**
     * Display a listing of management users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Get users with admin or super_admin roles
            $users = User::where('role', 'admin')
                        ->orWhere('role', 'super_admin')
                        ->with('role') // Eager load the role relationship
                        ->get();
            
            // Get all permissions
            $permissions = Permission::all();
            
            // Get all roles
            $roles = Role::all();
            
            // Get available modules
            $modules = $this->getAvailableModules();
            
            return view('admin.users.management', compact('users', 'permissions', 'modules', 'roles'));
        } catch (\Exception $e) {
            \Log::error('Error loading management users: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading users. Please try again.');
        }
    }
    
    /**
     * Store a newly created management user in storage.
     *
     * @param  ManagementUserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManagementUserStoreRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->all());

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $this->userService->handleUserPhotoUpload($request->file('photo'), $user);
            }
            
            // Assign role permissions if role_id is provided
            if ($request->role_id) {
                $this->userService->assignRolePermissions($user, $request->role_id);
            }
            
            // Assign additional permissions if provided
            if ($request->has('permissions')) {
                $this->userService->assignAdditionalPermissions($user, $request->permissions, $request->role_id);
            }

            return response()->json(['message' => 'User created successfully', 'user' => $user]);
        } catch (\Exception $e) {
            \Log::error('Error creating management user: ' . $e->getMessage());
            return response()->json(['errors' => ['general' => ['An error occurred while creating the user. Please try again.']]], 500);
        }
    }
    
    /**
     * Update the specified management user in storage.
     *
     * @param  ManagementUserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ManagementUserUpdateRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $user = $this->userService->updateUser($user, $request->all());
            
            // Handle photo upload
            if ($request->hasFile('photo')) {
                $this->userService->handleUserPhotoUpload($request->file('photo'), $user);
            }
            
            // Assign role permissions if role_id is provided
            if ($request->role_id) {
                $this->userService->assignRolePermissions($user, $request->role_id);
            }
            
            // Assign additional permissions if provided
            if ($request->has('permissions')) {
                $this->userService->assignAdditionalPermissions($user, $request->permissions, $request->role_id);
            } else if (!$request->role_id) {
                // If no role_id and no permissions, clear user permissions
                $user->permissions()->detach();
            }

            return response()->json(['message' => 'User updated successfully', 'user' => $user]);
        } catch (\Exception $e) {
            \Log::error('Error updating management user: ' . $e->getMessage());
            return response()->json(['errors' => ['general' => ['An error occurred while updating the user. Please try again.']]], 500);
        }
    }
    
    /**
     * Remove the specified management user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Prevent deletion of super admin users
            if ($user->role === 'super_admin') {
                return response()->json(['message' => 'Super admin users cannot be deleted'], 403);
            }
            
            $user->delete();
            
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Error deleting management user: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the user. Please try again.'], 500);
        }
    }
    
    /**
     * Toggle the status of the specified management user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(Request $request, $id)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json(['message' => 'Authentication required. Please log in again.'], 401);
            }
            
            // Check if user has proper permissions
            $currentUser = Auth::user();
            if (!$currentUser->isAdmin() && !$currentUser->isSuperAdmin()) {
                return response()->json(['message' => 'Insufficient permissions to perform this action.'], 403);
            }
            
            $user = User::findOrFail($id);
            
            // Prevent users from deactivating their own account
            if ($currentUser->id == $user->id && $user->status == 'active') {
                return response()->json(['message' => 'You cannot deactivate your own account.'], 403);
            }
            
            // Toggle status
            $user = $this->userService->toggleUserStatus($user, $currentUser->id);
            
            // Return appropriate status text with styling
            $statusText = $this->userService->getStatusText($user->status);
                
            return response()->json([
                'message' => 'Status updated successfully',
                'status_text' => $statusText
            ]);
        } catch (\Exception $e) {
            \Log::error('Error toggling user status: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the user status. Please try again.'], 500);
        }
    }
}