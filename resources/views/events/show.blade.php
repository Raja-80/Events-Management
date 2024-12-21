@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-4xl font-semibold mb-6">{{ $event->name }}</h1>

        <div class="mb-4">
            <p><strong>Date:</strong> {{ $event->date }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>RSVP Limit:</strong> {{ $event->rsvp_limit }}</p>
        </div>

        {{-- Admin Options (Edit and Delete) --}}
        @auth
            @if(auth()->user() && auth()->user()->role === 'admin')
                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('events.edit', $event->id) }}" class="bg-yellow-500 text-black px-4 py-2 rounded-md">Edit Event</a>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Delete Event</button>
                    </form>
                </div>
            @elseif($event->rsvp_limit > 0) 
                @if(!$event->rsvps->contains('user_id', auth()->id()))
                    <form action="{{ route('events.rsvp', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">RSVP</button>
                    </form>
                @else
                    <p class="mt-4 text-green-500">You have already RSVP'd to this event.</p>
                @endif
            @else
                <p class="text-yellow-500">RSVPs are not allowed for this event because the RSVP limit has been reached.</p>
            @endif
        @else
            <p>Please <a href="{{ route('login') }}" class="text-blue-500 hover:underline">login</a> to RSVP.</p>
        @endauth
    </div>
@endsection
