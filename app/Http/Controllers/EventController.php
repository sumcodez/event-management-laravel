<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        // Fetch the logged-in user
        $user = Auth::user();

        // Access first_name and last_name
        $fullName = $user ? $user->first_name . ' ' . $user->last_name : 'Guest';

        $events = Event::all();
        $venues = Venue::all();
        return view('admin.events', compact('events', 'venues', 'fullName'));
    }

    public function createEvent(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => [
                'required',
                Rule::unique('events')->where(function ($query) use ($request) {
                    return $query->where('date', $request->date)
                                ->where('venue_id', $request->venue_id);  // Use venue_id here
                }),
            ],
            'description' => 'nullable|string',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'venue_id' => 'required|exists:venues,id',  // Ensure the venue_id exists in the venues table
        ]);

        // Create the event with the venue_id
        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'venue_id' => $request->venue_id,  // Store the venue_id directly
            'created_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Event added successfully!');
    }


    public function updateEvent(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'title' => [
                'required',
                Rule::unique('events')->ignore($id)->where(function ($query) use ($request) {
                    return $query->where('date', $request->date)
                                ->where('venue_id', $request->venue_id);
                }),
            ],
            'description' => 'nullable|string',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'venue_id' => 'required|exists:venues,id',  // Ensure the venue_id exists in the venues table
        ]);

        // Find the event by id
        $event = Event::findOrFail($id);

        // Update the event's details
        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'venue_id' => $request->venue_id,  // Update the venue_id
        ]);

        return redirect()->back()->with('success', 'Event updated successfully!');
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('success', 'Event deleted successfully!');
    }


    public function allEvents_user(Request $request)
    {
        // Get the search and filter parameters from the request
        $search = $request->input('title');
        $venueFilter = $request->input('venue');
        $dateFilter = $request->input('date');
    
        // Query the events based on the filters
        $events = Event::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->when($venueFilter, function ($query) use ($venueFilter) {
                return $query->where('venue_id', $venueFilter);
            })
            ->when($dateFilter, function ($query) use ($dateFilter) {
                return $query->whereDate('date', $dateFilter);
            })
            ->get();
    
        // Get all venues for the filter dropdown
        $venues = Venue::all();
    
        return view('users.events', compact('events', 'venues', 'search', 'venueFilter', 'dateFilter'));
    }


    public function showRegisteredEvents()
    {
        // Get the logged-in user's ID
        $userId = auth()->user()->id;
    
        // Fetch all events associated with the user, including the venue details
        $registeredEvents = DB::table('attendees')
            ->join('events', 'attendees.event_id', '=', 'events.id')
            ->join('venues', 'events.venue_id', '=', 'venues.id') // Join with the venues table
            ->where('attendees.user_id', $userId)
            ->get(['events.*', 'venues.name as venue_title', 'venues.location as venue_location', 'venues.capacity as venue_capacity']); // Fetch venue details as well
    
        return view('users.registered', compact('registeredEvents'));
    }
}
