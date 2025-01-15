<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Example: Fetch some data for the admin dashboard
        $userCount = \App\Models\User::count(); // Total number of users
        //$recentActivities = \App\Models\Activity::latest()->take(10)->get(); // Last 10 activities

        $user = Auth::user();

        // Access first_name and last_name
        $fullName = $user ? $user->first_name . ' ' . $user->last_name : 'Guest';

        return view('admin.index', compact('fullName'));
    }
}
