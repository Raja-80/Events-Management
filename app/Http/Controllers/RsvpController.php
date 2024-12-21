<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RsvpController extends Controller
{

    public function store(Request $request, Event $event)
    {
        if ($event->rsvps()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already RSVP\'d for this event.');
        }

        if ($event->rsvps()->count() >= $event->rsvp_limit) {
            return back()->with('error', 'This event has reached its RSVP limit.');
        }

        $event->decrement('rsvp_limit');

        Rsvp::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        return back()->with('success', 'You have successfully RSVP\'d for the event!');
    }

}
