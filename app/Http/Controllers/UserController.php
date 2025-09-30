<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the user profile.
     *
     * @return \Illuminate\View\View
     */
    public function showProfile()
    {
        $user = Auth::user();
        return view('admin.profile.show', compact('user'));
    }
    
    /**
     * Update the user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'contact' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

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
    }
    
    /**
     * Update the user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect'])->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->markPasswordAsChanged();
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully');
    }
    
    /**
     * Display a listing of management users.
     *
     * @return \Illuminate\View\View
     */
    public function managementUsers()
    {
        // Get users with admin or super_admin roles
        $users = User::where('role', 'admin')
                    ->orWhere('role', 'super_admin')
                    ->get();
        
        return view('admin.users.management', compact('users'));
    }
    
    /**
     * Store a newly created management user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeManagementUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'contact' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'role' => 'required|in:admin,super_admin',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact' => $request->contact,
            'dob' => $request->dob,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/images/avatars'), $filename);
            $user->photo = $filename;
            $user->save();
        }

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }
    
    /**
     * Update the specified management user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateManagementUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
            'contact' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'role' => 'required|in:admin,super_admin',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->dob = $request->dob;
        $user->role = $request->role;
        $user->status = $request->status;
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/images/avatars'), $filename);
            $user->photo = $filename;
        }
        
        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
    
    /**
     * Remove the specified management user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteManagementUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deletion of super admin users
        if ($user->role === 'super_admin') {
            return response()->json(['message' => 'Super admin users cannot be deleted'], 403);
        }
        
        $user->delete();
        
        return response()->json(['message' => 'User deleted successfully']);
    }
    
    /**
     * Toggle the status of the specified management user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleUserStatus(Request $request, $id)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['message' => 'Authentication required. Please log in again.'], 401);
        }
        
        // Check if user has proper permissions
        $currentUser = Auth::user();
        if (!$currentUser->isAdmin() && !$currentUser->isSuperAdmin()) {
            return response()->json(['message' => 'Insufficient permissions to perform this action.'], 403);
        }
        
        try {
            $user = User::findOrFail($id);
            
            // Prevent users from deactivating their own account
            if ($currentUser->id == $user->id && $user->status == 'active') {
                return response()->json(['message' => 'You cannot deactivate your own account.'], 403);
            }
            
            // Toggle status
            $user->status = $user->status == 'active' ? 'inactive' : 'active';
            $user->save();
            
            // Return appropriate status text with styling
            $statusText = $user->status == 'active' 
                ? '<span class="text-success fw-bold">Active</span>' 
                : '<span class="text-secondary fw-bold">Inactive</span>';
                
            return response()->json([
                'message' => 'Status updated successfully',
                'status_text' => $statusText
            ]);
        } catch (\Exception $e) {
            \Log::error('Error toggling user status: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the user status. Please try again.'], 500);
        }
    }
    
    /**
     * Display a listing of regular users.
     *
     * @return \Illuminate\View\View
     */
    public function regularUsers()
    {
        // Get users with regular user role
        $users = User::where('role', 'user')->get();
        
        return view('admin.users.regular', compact('users'));
    }
    
    /**
     * Store a newly created regular user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeRegularUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'contact' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contact' => $request->contact,
            'dob' => $request->dob,
            'role' => 'user',
            'status' => $request->status,
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/images/avatars'), $filename);
            $user->photo = $filename;
            $user->save();
        }

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }
    
    /**
     * Update the specified regular user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRegularUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Ensure user is a regular user
        if ($user->role !== 'user') {
            return response()->json(['message' => 'User is not a regular user'], 400);
        }
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
            'contact' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->contact = $request->contact;
        $user->dob = $request->dob;
        $user->status = $request->status;
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        
        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('assets/images/avatars'), $filename);
            $user->photo = $filename;
        }
        
        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }
    
    /**
     * Remove the specified regular user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteRegularUser($id)
    {
        $user = User::findOrFail($id);
        
        // Ensure user is a regular user
        if ($user->role !== 'user') {
            return response()->json(['message' => 'User is not a regular user'], 400);
        }
        
        $user->delete();
        
        return response()->json(['message' => 'User deleted successfully']);
    }
    
    /**
     * Toggle the status of the specified regular user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleRegularUserStatus(Request $request, $id)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['message' => 'Authentication required. Please log in again.'], 401);
        }
        
        // Check if user has proper permissions
        $currentUser = Auth::user();
        if (!$currentUser->isAdmin() && !$currentUser->isSuperAdmin()) {
            return response()->json(['message' => 'Insufficient permissions to perform this action.'], 403);
        }
        
        try {
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
            $user->status = $user->status == 'active' ? 'inactive' : 'active';
            $user->save();
            
            // Return appropriate status text with styling
            $statusText = $user->status == 'active' 
                ? '<span class="text-success fw-bold">Active</span>' 
                : '<span class="text-secondary fw-bold">Inactive</span>';
                
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