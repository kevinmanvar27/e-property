<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Http\Requests\UserPasswordUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        return view('admin.profile.show', compact('user'));
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
            
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->contact = $request->contact;
            $user->dob = $request->dob;
            
            // Handle photo upload
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $filename = time() . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('assets/images/avatars'), $filename);
                $user->photo = $filename;
            }
            
            $user->save();

            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating user profile: ' . $e->getMessage());
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
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
            }

            $user->password = Hash::make($request->password);
            $user->markPasswordAsChanged();
            $user->save();

            return redirect()->back()->with('success', 'Password updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating user password: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating your password. Please try again.');
        }
    }
}