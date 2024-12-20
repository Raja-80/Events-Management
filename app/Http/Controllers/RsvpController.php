<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RsvpController extends Controller
{
    // RSVP to an event
    public function store(Request $request, Event $event)
    {
        // Check if the user has already RSVP'd for this event
        if ($event->rsvps()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already RSVP\'d for this event.');
        }

        // Check if there are available spots for RSVP
        if ($event->rsvps()->count() >= $event->rsvp_limit) {
            return back()->with('error', 'This event has reached its RSVP limit.');
        }

        // Create the RSVP
        Rsvp::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        return back()->with('success', 'You have successfully RSVP\'d for the event!');
    }

    // Show all RSVPs for the event (Admin only)
    public function show(Event $event)
    {
        $this->authorize('viewAny', Rsvp::class);  // Only allow admin users to view RSVPs

        $rsvps = $event->rsvps;  // Get all RSVPs for the event
        return view('rsvps.index', compact('event', 'rsvps'));
    }
}
