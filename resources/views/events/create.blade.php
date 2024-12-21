{{-- resources/views/events/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold mb-6">Create a New Event</h1>

        <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Event Name -->
            <div>
                <label for="name" class="block">Event Name</label>
                <input type="text" name="name" id="name" 
                    class="px-4 py-2 border rounded-md w-full @error('name') border-red-500 @enderror" 
                    value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Event Date -->
            <div>
                <label for="date" class="block">Event Date</label>
                <input type="date" name="date" id="date" 
                    class="px-4 py-2 border rounded-md w-full @error('date') border-red-500 @enderror" 
                    value="{{ old('date') }}" required>
                @error('date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Event Location -->
            <div>
                <label for="location" class="block">Location</label>
                <input type="text" name="location" id="location" 
                    class="px-4 py-2 border rounded-md w-full @error('location') border-red-500 @enderror" 
                    value="{{ old('location') }}" required>
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Event Description -->
            <div>
                <label for="description" class="block">Description</label>
                <textarea name="description" id="description" 
                    class="px-4 py-2 border rounded-md w-full @error('description') border-red-500 @enderror" 
                    required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- RSVP Limit -->
            <div>
                <label for="rsvp_limit" class="block">RSVP Limit</label>
                <input type="number" name="rsvp_limit" id="rsvp_limit" 
                    class="px-4 py-2 border rounded-md w-full @error('rsvp_limit') border-red-500 @enderror" 
                    value="{{ old('rsvp_limit', 1) }}" min="1" max="500" required>
                @error('rsvp_limit')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Create Event
                </button>
            </div>
        </form>
    </div>
@endsection
