@extends('layouts.app')

@section('content')
    <div class="container-edit">
        <h1 class="page-title">Create a New Event</h1>

        <form action="{{ route('events.store') }}" method="POST" class="form-wrapper">
            @csrf

            <!-- Name and Location -->
            <div class="form-row">
                <div class="form-group">
                    <label for="name" class="form-label">Event Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-input @error('name') error-border @enderror" 
                        value="{{ old('name') }}" 
                        required
                    >
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Location</label>
                    <input 
                        type="text" 
                        name="location" 
                        id="location" 
                        class="form-input @error('location') error-border @enderror" 
                        value="{{ old('location') }}" 
                        required
                    >
                    @error('location')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Date and RSVP Limit -->
            <div class="form-row">
                <div class="form-group">
                    <label for="date" class="form-label">Event Date</label>
                    <input 
                        type="date" 
                        name="date" 
                        id="date" 
                        class="form-input @error('date') error-border @enderror" 
                        value="{{ old('date') }}" 
                        required
                    >
                    @error('date')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rsvp_limit" class="form-label">RSVP Limit</label>
                    <input 
                        type="number" 
                        name="rsvp_limit" 
                        id="rsvp_limit" 
                        class="form-input @error('rsvp_limit') error-border @enderror" 
                        value="{{ old('rsvp_limit', 1) }}" 
                        min="1" 
                        max="500" 
                        required
                    >
                    @error('rsvp_limit')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea 
                    name="description" 
                    id="description" 
                    class="form-textarea @error('description') error-border @enderror" 
                    rows="7" 
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="submit-button">
                    Create Event
                </button>
            </div>
        </form>
    </div>
@endsection
