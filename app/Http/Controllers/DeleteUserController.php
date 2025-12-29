<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DeleteUserController extends Controller
{
    /**
     * Show the delete user form
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showDeleteForm(Request $request)
    {
        // Get email and password from URL parameters
        $email = $request->query('email');
        $password = $request->query('password');
        
        return view('admin.users.delete', compact('email', 'password'));
    }

    /**
     * Delete user after verifying credentials
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $email = $request->input('email');
            $password = $request->input('password');

            // Find the user by email
            $user = User::where('email', $email)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'User not found with the provided email.');
            }

            // Verify the password
            if (!Hash::check($password, $user->password)) {
                return redirect()->back()->with('error', 'Invalid password. User deletion failed.');
            }

            // Prevent deletion of super admin users
            if ($user->role === 'super_admin') {
                return redirect()->back()->with('error', 'Super admin users cannot be deleted.');
            }

            // Store user info for success message
            $userName = $user->name;
            $userEmail = $user->email;

            // Delete the user
            $user->delete();

            Log::info("User deleted successfully", [
                'email' => $userEmail,
                'name' => $userName,
                'deleted_at' => now()
            ]);

            return redirect()->route('user.delete.form')->with('success', "User '{$userName}' ({$userEmail}) has been deleted successfully.");

        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the user. Please try again.');
        }
    }
}
