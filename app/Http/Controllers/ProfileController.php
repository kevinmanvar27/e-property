<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ProfileController extends Controller
{
    /**
     * Display the user profile.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();

        // Check if this is an admin user
        if ($user->isAdmin()) {
            return view('admin.profile.show', compact('user'));
        }

        // For regular users, redirect to their profile page
        return redirect()->route('user-profile');
    }

    /**
     * Update the user profile.
     *
     * @param  UserProfileUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserProfileUpdateRequest $request)
    {
        try {
            $user = Auth::user();

            // Update user fields
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->dob = $request->dob;

            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo if it exists
                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }
                
                $photo = $request->file('photo');
                $filename = time() . '.' . $photo->getClientOriginalExtension();
                // Store in public disk for user profile photos
                Storage::disk('public')->putFileAs('', $photo, $filename);
                $user->photo = $filename;
            }

            $user->save();

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json(['message' => 'Profile updated successfully']);
            }

            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating user profile: ' . $e->getMessage());

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while updating your profile. Please try again.'], 500);
            }

            return redirect()->back()->with('error', 'An error occurred while updating your profile. Please try again.');
        }
    }

    /**
     * Update the user password.
     *
     * @param  UserPasswordUpdateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UserPasswordUpdateRequest $request)
    {
        try {
            $user = Auth::user();

            // Check if current password is correct
            if (! Hash::check($request->current_password, $user->password)) {
                // Check if this is an AJAX request
                if ($request->ajax()) {
                    return response()->json(['errors' => ['current_password' => 'Current password is incorrect']], 422);
                }
                return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
            }

            $user->password = Hash::make($request->password);
            $user->markPasswordAsChanged();
            $user->save();

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json(['message' => 'Password updated successfully']);
            }

            return redirect()->back()->with('success', 'Password updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating user password: ' . $e->getMessage());

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while updating your password. Please try again.'], 500);
            }

            return redirect()->back()->with('error', 'An error occurred while updating your password. Please try again.');
        }
    }
}