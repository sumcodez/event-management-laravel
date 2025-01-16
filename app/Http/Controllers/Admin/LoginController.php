<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showAdminLogin() {
        return view('admin.login');
    }

    public function login(Request $request){
        dd($request->all());
    }

    public function showAdminDashboard(){
        // Fetch the logged-in user
        $user = Auth::user();

        // Access first_name and last_name
        $fullName = $user ? $user->first_name . ' ' . $user->last_name : 'Guest';

        return view('admin.index', compact('fullName'));
    }


    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Attempt to authenticate user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Check if the user is an admin
            if (!$user->is_admin) {
                Auth::logout(); // Log out the user if they are not an admin
                return back()->withErrors([
                    'errors' => 'You do not have access to the admin dashboard.',
                ]);
            }

            // Regenerate session and redirect to the admin dashboard
            $request->session()->regenerate();
            session()->flash('success', 'Logged in successfully as admin.');
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'errors' => 'The provided credentials are incorrect.',
        ]);
    }

}
