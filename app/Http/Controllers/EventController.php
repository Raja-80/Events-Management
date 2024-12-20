<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // $events = Event::all();  // Get all events
        return view('home');
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
            'name' => 'required|max:255',
            'date' => 'required|date',
            'location' => 'required',
            'description' => 'required',
            'rsvp_limit' => 'required|integer|min:1',
        ]);

        $event = Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
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
            'name' => 'required|max:255',
            'date' => 'required|date',
            'location' => 'required',
            'description' => 'required',
            'rsvp_limit' => 'required|integer|min:1',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    // Delete an event (Admin only)
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
