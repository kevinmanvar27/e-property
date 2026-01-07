<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DeleteUserApiController extends Controller
{
    /**
     * Delete user after verifying credentials
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUser(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $request->input('email');
            $password = $request->input('password');

            // Find the user by email
            $user = User::where('email', $email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found with the provided email.'
                ], 404);
            }

            // Verify the password
            if (!Hash::check($password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid password. User deletion failed.'
                ], 401);
            }

            // Prevent deletion of super admin users
            if ($user->role === 'super_admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Super admin users cannot be deleted.'
                ], 403);
            }

            // Store user info for success message
            $userName = $user->name;
            $userEmail = $user->email;
            $userId = $user->id;

            // Delete the user
            $user->delete();

            Log::info("User deleted successfully via API", [
                'user_id' => $userId,
                'email' => $userEmail,
                'name' => $userName,
                'deleted_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => "User '{$userName}' ({$userEmail}) has been deleted successfully.",
                'data' => [
                    'deleted_user' => [
                        'id' => $userId,
                        'name' => $userName,
                        'email' => $userEmail
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error deleting user via API: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the user. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
