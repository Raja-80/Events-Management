{{-- resources/views/events/show.blade.php --}}
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

        {{-- RSVP Form (Only for authenticated users) --}}
        @auth
            @if(!$event->rsvps->contains('user_id', auth()->id()))
                <form action="{{ route('events.rsvp', $event->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">RSVP</button>
                </form>
            @else
                <p class="mt-4 text-green-500">You have already RSVP'd to this event.</p>
            @endif
        @else
            <p>Please <a href="{{ route('login') }}" class="text-blue-500 hover:underline">login</a> to RSVP.</p>
        @endauth
    </div>
@endsection
