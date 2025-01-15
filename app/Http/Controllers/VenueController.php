<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Venue;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{
    public function allVenues() {
        // Fetch the logged-in user
        $user = Auth::user();

        // Access first_name and last_name
        $fullName = $user ? $user->first_name . ' ' . $user->last_name : 'Guest';

        $venues = Venue::all();

        return view('admin.venues', compact('venues', 'fullName'));
    }
    
    public function createVenue(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        Venue::create($request->all());
        return redirect()->back()->with('success', 'Venue added successfully!');
    }

    public function updateVenue(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        $venue = Venue::findOrFail($id); // Find the venue by ID
        $venue->update($request->all());

        return redirect()->back()->with('success', 'Venue updated successfully!');
    }

    public function deleteVenue($id) {
        $venue = Venue::findOrFail($id);
        $venue->delete();
        return redirect()->back()->with('success', 'Venue deleted successfully!');
    }

}
