<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegularUserStoreRequest;
use App\Http\Requests\RegularUserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegularUserApiController extends Controller
{
    /**
     * Display a listing of regular users.
     */
    public function index()
    {
        try {
            $users = User::where('user_type', 'regular')
                ->select(['id', 'name', 'email', 'phone', 'status', 'created_at'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $users,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading regular users: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading regular users. Please try again.',
            ], 500);
        }
    }

    /**
     * Store a newly created regular user.
     */
    public function store(RegularUserStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            $data['user_type'] = 'regular';

            $user = User::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Regular user created successfully',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating regular user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the regular user. Please try again.',
            ], 500);
        }
    }

    /**
     * Display the specified regular user.
     */
    public function show(User $regular_user)
    {
        try {
            // Ensure user is of regular type
            if ($regular_user->user_type !== 'regular') {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $regular_user,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading regular user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading the regular user. Please try again.',
            ], 500);
        }
    }

    /**
     * Update the specified regular user.
     */
    public function update(RegularUserUpdateRequest $request, User $regular_user)
    {
        try {
            // Ensure user is of regular type
            if ($regular_user->user_type !== 'regular') {
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

            $regular_user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Regular user updated successfully',
                'data' => $regular_user,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating regular user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the regular user. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified regular user.
     */
    public function destroy(User $regular_user)
    {
        try {
            // Ensure user is of regular type
            if ($regular_user->user_type !== 'regular') {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }

            $regular_user->delete();

            return response()->json([
                'success' => true,
                'message' => 'Regular user deleted successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting regular user: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the regular user. Please try again.',
            ], 500);
        }
    }

    /**
     * Toggle status of the specified regular user.
     */
    public function toggleStatus(User $regular_user)
    {
        try {
            // Ensure user is of regular type
            if ($regular_user->user_type !== 'regular') {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }

            $regular_user->status = $regular_user->status === 'active' ? 'inactive' : 'active';
            $regular_user->save();

            $statusText = $regular_user->status === 'active' ?
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
            \Log::error('Error toggling regular user status: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the user status. Please try again.',
            ], 500);
        }
    }
}
