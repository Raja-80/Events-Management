@extends('layouts.app')

@section('content')
    <div class="containerevent">
        <h1 class="event-title">{{ $event->name }}</h1>

        <div class="event-details">
            <p><strong>Date:</strong> {{ $event->date }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Description:</strong> {{ $event->description }}</p>
            <p><strong>RSVP Limit:</strong> {{ $event->rsvp_limit }}</p>
        </div>

        {{-- Admin Options (Edit and Delete) --}}
        @auth
            @if (auth()->user() && auth()->user()->role === 'admin')
                <div class="admin-actions">
                    <a href="{{ route('events.edit', $event->id) }}" class="edit-btn">Edit Event</a>
                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" onsubmit="return confirmDelete()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Delete Event</button>
                    </form>
                </div>
            @elseif($event->rsvp_limit > 0)
                @if (!$event->rsvps->contains('user_id', auth()->id()))
                    <form action="{{ route('events.rsvp', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="rsvp-btn">RSVP</button>
                    </form>
                @else
                    <p class="rsvp-info success">You have already RSVP'd to this event.</p>
                @endif
            @else
                <p class="rsvp-info warning">RSVPs are not allowed for this event because the RSVP limit has been reached.</p>
            @endif
        @else
            <p>Please <a href="{{ route('login') }}" class="login-link">login</a> to RSVP.</p>
        @endauth
    </div>
@endsection

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this event?');
    }
</script>
