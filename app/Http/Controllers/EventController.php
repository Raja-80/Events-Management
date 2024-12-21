<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class EventController extends Controller
{
    // Constructor to ensure the admin middleware
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    // Display all events
    public function index()
    {
        $events = Event::all();  // Get all events
        return view('home', compact('events'));
    }

    // Display a single event's details
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    // Show the form to create a new event (Admin only)
    public function create()
    {
        return view('events.create');
    }

    // Store a new event in the database (Admin only)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|after:today',
            'location' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'rsvp_limit' => 'required|integer|min:1|max:500', // RSVP limit between 1 and 500
        ]);

        $event = Event::create($request->all());

        return redirect()->route('events.app')->with('success', 'Event created successfully.');
    }

    // Show the form to edit an existing event (Admin only)
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    // Update an existing event (Admin only)
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|after:today',
            'location' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'rsvp_limit' => 'required|integer|min:1|max:500', // RSVP limit between 1 and 500
        ]);

        $event->update($request->all());

        return redirect()->route('events.app')->with('success', 'Event updated successfully.');
    }

    // Delete an event (Admin only)
    public function destroy(Event $event)
    {
        Log::info('Destroy method is being triggered');
        $event->delete();

        return redirect()->route('events.app')->with('success', 'Event deleted successfully.');
    }
}
