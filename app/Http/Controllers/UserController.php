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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
        ]);

        //return redirect()->route('events.all')->with('success', 'Profile updated successfully!');
        return back()->with('success', 'Profile updated successfully!');
    }
}
