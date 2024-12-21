<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class EventController extends Controller
{

    public function __construct() {}

    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->has('location') && $request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date', '=', $request->date);
        }

        $allEvents = $query->get();
       
        if ($request->location || $request->date) {
            if ($allEvents->isEmpty()) {
                session()->flash('info', 'There are no events with the selected filters.');
            }
        } else {

            $allEvents = Event::all();
        }

        return view('home', compact('allEvents'));
    }



    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function create()
    {

        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|after:today',
            'location' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'rsvp_limit' => 'required|integer|min:1|max:500',
        ]);

        Event::create($request->all());

        return redirect()->route('home')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|after:today',
            'location' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'rsvp_limit' => 'required|integer|min:1|max:500',
        ]);

        $event->update($request->all());

        return redirect()->route('home')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        Log::info('Destroy method is being triggered');
        $event->delete();

        return redirect()->route('home')->with('success', 'Event deleted successfully.');
    }
}
