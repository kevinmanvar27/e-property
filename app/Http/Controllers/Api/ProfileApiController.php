<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; // Import the Storage facade
use Illuminate\Support\Facades\Validator;


/**
 * @OA\Schema(
 *     schema="ProfileUpdateRequest",
 *     type="object",
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="phone", type="string", example="1234567890")
 * )
 *
 * @OA\Schema(
 *     schema="PasswordUpdateRequest",
 *     type="object",
 *     @OA\Property(property="current_password", type="string", example="currentpassword"),
 *     @OA\Property(property="password", type="string", example="newpassword"),
 *     @OA\Property(property="password_confirmation", type="string", example="newpassword")
 * )
 *
 * @OA\Schema(
 *     schema="ProfileResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *         @OA\Property(property="phone", type="string", example="1234567890"),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="ProfileUpdateResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Profile updated successfully"),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *         @OA\Property(property="phone", type="string", example="1234567890"),
 *         @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00.000000Z")
 *     )
 * )
 *
 * @OA\Tag(
 *     name="User Profile",
 *     description="API Endpoints for User Profile Management"
 * )
 */

class ProfileApiController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/profile",
     *      operationId="getProfile",
     *      tags={"User Profile"},
     *      summary="Get user profile",
     *      description="Retrieve the authenticated user's profile information",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ProfileResponse")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function show(Request $request)
    {
        try {
            // Load the user with their role and permissions
            $user = $request->user()->load('role', 'permissions');

            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading profile: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading the profile. Please try again.',
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/profile",
     *      operationId="updateProfile",
     *      tags={"User Profile"},
     *      summary="Update user profile",
     *      description="Update the authenticated user's profile information",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ProfileUpdateRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ProfileUpdateResponse")
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */

    public function update(Request $request)
    {
        $user = $request->user();

        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ],
                'contact' => 'nullable|string|max:20',
                'dob' => 'nullable|date',
                'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors'  => $validator->errors()
                ], 422);
            }

            // Update fields
            $user->fill($request->only(['name', 'email', 'contact', 'dob']));

            // Handle photo
            if ($request->hasFile('photo')) {

                // Delete old photo
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }

                $photo = $request->file('photo');
                $filename = time() . '.' . $photo->getClientOriginalExtension();

                // Store photo inside photos/ folder
                Storage::disk('public')->putFileAs('photos', $photo, $filename);

                // Store path like photos/xxxx.jpg
                $user->photo = 'photos/' . $filename;
            }

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
            ]);

        } catch (\Exception $e) {

            Log::error('Error updating profile (API): ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/profile/password",
     *      operationId="updatePassword",
     *      tags={"User Profile"},
     *      summary="Update user password",
     *      description="Update the authenticated user's password",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PasswordUpdateRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Password updated successfully")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation Error"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *      )
     * )
     */
    public function updatePassword(Request $request)
    {
        try {
            $user = $request->user();

            $request->validate([
                'current_password' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Check if current password is correct
            if (! Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect.',
                ], 422);
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the password. Please try again.',
            ], 500);
        }
    }
}