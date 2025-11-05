<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManagementUserStoreRequest;
use App\Http\Requests\ManagementUserUpdateRequest;
use App\Http\Requests\RegularUserStoreRequest;
use App\Http\Requests\RegularUserToggleStatusRequest;
use App\Http\Requests\RegularUserUpdateRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

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
            $users = User::where('role', 'user')->with('role')->get();

            return view('admin.users.regular', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error loading regular users: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while loading users. Please try again.');
        }
    }

    /**
     * Store a newly created regular user in storage.
     *
     * @param  RegularUserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegularUserStoreRequest $request)
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
            Log::error('Error creating regular user: ' . $e->getMessage());

            return response()->json(['errors' => ['general' => ['An error occurred while creating the user. Please try again.']]], 500);
        }
    }

    /**
     * Update the specified regular user in storage.
     *
     * @param  RegularUserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegularUserUpdateRequest $request, $id)
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
            Log::error('Error updating regular user: ' . $e->getMessage());

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

            // Delete user photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->delete();

            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting regular user: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while deleting the user. Please try again.'], 500);
        }
    }

    /**
     * Toggle the status of the specified regular user.
     *
     * @param  RegularUserToggleStatusRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(RegularUserToggleStatusRequest $request, $id)
    {
        try {
            $currentUser = Auth::user();
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
                'status_text' => $statusText,
            ]);
        } catch (\Exception $e) {
            Log::error('Error toggling user status: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while updating the user status. Please try again.'], 500);
        }
    }
}
