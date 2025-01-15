<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Attendee;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AttendeeController extends Controller
{
    public function register(Request $request, $event_id)
    {
        // Fetch the event and associated venue
        $event = Event::findOrFail($event_id);
    
        // Fetch the venue details using the venue_id from the event
        $venue = Venue::findOrFail($event->venue_id);
    
        // Check for duplicate registrations
        $existingRegistration = Attendee::where('user_id', Auth::id())
            ->where('event_id', $event_id)
            ->first();
    
        if ($existingRegistration) {
            return redirect()->back()->with('error', 'You are already registered for this event.');
        }
    
        // Check venue capacity
        $registeredAttendeesCount = Attendee::where('event_id', $event_id)->count();
        $venueCapacity = $venue->capacity;
    
        if ($registeredAttendeesCount >= $venueCapacity) {
            return redirect()->back()->with('error', 'The venue is at full capacity.');
        }
    
        // Register the attendee
        Attendee::create([
            'user_id' => Auth::id(),
            'event_id' => $event_id,
            'registered_at' => now(), // Add the current timestamp
        ]);
    
        return redirect()->back()->with('success', 'You have successfully registered for the event.');
    }
    


    public function show($event_id)
    {
        $event = Event::findOrFail($event_id); // Retrieve the event by ID
        $venue = Venue::find($event->venue_id); // Find the venue using the event's venue_id

        // Check if the user is already registered
        $isRegistered = Attendee::where('user_id', Auth::id())
        ->where('event_id', $event_id)
        ->exists();
    
        return view('users.showEvent', compact('event', 'venue', 'isRegistered')); // Pass both event and venue to the view
    }
}
