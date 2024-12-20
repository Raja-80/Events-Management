{{-- resources/views/events/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold mb-6">Create a New Event</h1>

        <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block">Event Name</label>
                <input type="text" name="name" id="name" class="px-4 py-2 border rounded-md w-full" value="{{ old('name') }}" required>
            </div>

            <div>
                <label for="date" class="block">Event Date</label>
                <input type="date" name="date" id="date" class="px-4 py-2 border rounded-md w-full" value="{{ old('date') }}" required>
            </div>

            <div>
                <label for="location" class="block">Location</label>
                <input type="text" name="location" id="location" class="px-4 py-2 border rounded-md w-full" value="{{ old('location') }}" required>
            </div>

            <div>
                <label for="description" class="block">Description</label>
                <textarea name="description" id="description" class="px-4 py-2 border rounded-md w-full" required>{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="rsvp_limit" class="block">RSVP Limit</label>
                <input type="number" name="rsvp_limit" id="rsvp_limit" class="px-4 py-2 border rounded-md w-full" value="{{ old('rsvp_limit') }}" required>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Create Event</button>
            </div>
        </form>
    </div>
@endsection
