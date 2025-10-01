<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\ManagementUserStoreRequest;
use App\Http\Requests\ManagementUserUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegularUserController extends Controller
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    /**
     * Display a listing of regular users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Get users with regular user role
            $users = User::where('role', 'user')->get();
            
            return view('admin.users.regular', compact('users'));
        } catch (\Exception $e) {
            \Log::error('Error loading regular users: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading users. Please try again.');
        }
    }
    
    /**
     * Store a newly created regular user in storage.
     *
     * @param  ManagementUserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManagementUserStoreRequest $request)
    {
        try {
            $data = $request->all();
            $data['role'] = 'user';
            
            $user = $this->userService->createUser($data);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                $this->userService->handleUserPhotoUpload($request->file('photo'), $user);
            }

            return response()->json(['message' => 'User created successfully', 'user' => $user]);
        } catch (\Exception $e) {
            \Log::error('Error creating regular user: ' . $e->getMessage());
            return response()->json(['errors' => ['general' => ['An error occurred while creating the user. Please try again.']]], 500);
        }
    }
    
    /**
     * Update the specified regular user in storage.
     *
     * @param  ManagementUserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ManagementUserUpdateRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Ensure user is a regular user
            if ($user->role !== 'user') {
                return response()->json(['message' => 'User is not a regular user'], 400);
            }
            
            $data = $request->all();
            $data['role'] = 'user';
            
            $user = $this->userService->updateUser($user, $data);
            
            // Handle photo upload
            if ($request->hasFile('photo')) {
                $this->userService->handleUserPhotoUpload($request->file('photo'), $user);
            }

            return response()->json(['message' => 'User updated successfully', 'user' => $user]);
        } catch (\Exception $e) {
            \Log::error('Error updating regular user: ' . $e->getMessage());
            return response()->json(['errors' => ['general' => ['An error occurred while updating the user. Please try again.']]], 500);
        }
    }
    
    /**
     * Remove the specified regular user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Ensure user is a regular user
            if ($user->role !== 'user') {
                return response()->json(['message' => 'User is not a regular user'], 400);
            }
            
            $user->delete();
            
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Error deleting regular user: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the user. Please try again.'], 500);
        }
    }
    
    /**
     * Toggle the status of the specified regular user.
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
            
            // Ensure user is a regular user
            if ($user->role !== 'user') {
                return response()->json(['message' => 'User is not a regular user'], 400);
            }
            
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