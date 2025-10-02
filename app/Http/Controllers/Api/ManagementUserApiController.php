<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManagementUserStoreRequest;
use App\Http\Requests\ManagementUserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManagementUserApiController extends Controller
{
    /**
     * Display a listing of management users.
     */
    public function index()
    {
        try {
            $users = User::where('user_type', 'management')
                ->select(['id', 'name', 'email', 'phone', 'status', 'created_at'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $users,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading management users: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading management users. Please try again.',
            ], 500);
        }
    }

    /**
     * Store a newly created management user.
     */
    public function store(ManagementUserStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $data['user_type'] = 'management';

            $user = User::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Management user created successfully',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating management user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the management user. Please try again.',
            ], 500);
        }
    }

    /**
     * Display the specified management user.
     */
    public function show(User $management_user)
    {
        try {
            // Ensure user is of management type
            if ($management_user->user_type !== 'management') {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $management_user,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading management user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading the management user. Please try again.',
            ], 500);
        }
    }

    /**
     * Update the specified management user.
     */
    public function update(ManagementUserUpdateRequest $request, User $management_user)
    {
        try {
            // Ensure user is of management type
            if ($management_user->user_type !== 'management') {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }

            $data = $request->validated();

            // Only update password if provided
            if (isset($data['password']) && ! empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $management_user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Management user updated successfully',
                'data' => $management_user,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating management user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the management user. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified management user.
     */
    public function destroy(User $management_user)
    {
        try {
            // Ensure user is of management type
            if ($management_user->user_type !== 'management') {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }

            $management_user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Management user deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting management user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the management user. Please try again.',
            ], 500);
        }
    }

    /**
     * Toggle status of the specified management user.
     */
    public function toggleStatus(User $management_user)
    {
        try {
            // Ensure user is of management type
            if ($management_user->user_type !== 'management') {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }

            $management_user->status = $management_user->status === 'active' ? 'inactive' : 'active';
            $management_user->save();

            $statusText = $management_user->status === 'active' ?
                '<span class="text-success fw-bold">Active</span>' :
                '<span class="text-secondary fw-bold">Inactive</span>';

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'data' => [
                    'status_text' => $statusText,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error toggling management user status: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the user status. Please try again.',
            ], 500);
        }
    }
}
