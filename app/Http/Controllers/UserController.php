<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Display the Manage Profile page with prefilled user data
    public function edit()
    {
        $user = Auth::user(); // Get the authenticated user
        return view('users.manage', compact('user'));
    }

    // Handle the update profile request
    public function update(Request $request)
    {
        // Validate the input data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Update the user's profile information
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        // Save the user with the updated profile picture (if any)
        $user->save();

        // Redirect back with a success message
        return back()->with('success', 'Profile updated successfully!');
    }


    public function update_profile_pic(Request $request)
    {
        // Validate the input data
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Add validation for profile picture
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($user->profile_picture && \Storage::exists('public/' . $user->profile_picture)) {
                \Storage::delete('public/' . $user->profile_picture);
            }

            // Store the new profile picture in the specified path
            $imagePath = $request->file('profile_picture')->store('uploads/profile_pictures', 'public');

            // Update the user's profile picture path
            $user->profile_picture = $imagePath;
            $user->save();

            // Return a success message
            return redirect()->back()->with('success', 'Profile picture updated successfully.');
        }

        // If no file was uploaded, return with a message
        return redirect()->back()->with('error', 'No profile picture uploaded.');
    }
    
    public function deactivate_user(Request $request)  {

        $user = Auth::user();
        if ($user) {
            $user->update([
                'status' => '5' // Ensure status is a string if it's an ENUM column
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Flash a success message
        session()->flash('success', 'Your account has been deactivated successfully.');

        // Redirect to a named route (e.g., 'home')
        return redirect('/');
    }
}
