@extends('layouts.app')

@section('content')
<div class="container">
    <div class="header">
        <div class="title-filter-container">
            <h1 class="title">Events</h1>

            <div class="filter-create">
                <form action="{{ route('home') }}" method="GET" class="filter-form">
                    <div class="filters">
                        <input type="text" name="location" value="{{ request()->get('location') }}"
                            placeholder="Filter by location" class="filter-input">
                        <input type="date" name="date" value="{{ request()->get('date') }}" class="filter-input">
                    </div>
                    <div class="filtericonbox">
                        <button type="submit" class="filtericon" data-tooltip="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-search">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </button>
                    </div>
                </form>

                <div class="actions">
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('events.create') }}" class="createicon" data-tooltip="Add an Event">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-plus">
                                    <path d="M5 12h14" />
                                    <path d="M12 5v14" />
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    @if (session('info'))
        <div class="info-message">
            {{ session('info') }}
            <div class="image-empty">
                <img height="430px" src="{{ 'images/empty.png' }}" alt="">
            </div>
        </div>
    @endif

    {{-- Event List --}}
    <div class="event-list">
        @foreach ($allEvents as $event)
            <div class="event-card" onclick="showEventDetails({{ $event->id }})">
                <div class="event-date">
                    <span class="date-number">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                    <span class="date-month">{{ \Carbon\Carbon::parse($event->date)->format('M') }}</span>
                </div>

                <div class="event-details">
                    <h2 class="event-name">{{ $event->name }}</h2>
                    <p class="event-description">{{ Str::limit($event->description, 90) }}</p>
                </div>

                <div class="event-actions">
                    <a href="{{ route('events.show', $event->id) }}" class="view-details">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            fill="none" stroke="currentcolor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-eye">
                            <path
                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </a>

                    @if (auth()->user() && auth()->user()->role === 'admin')
                        <div class="edit-delete">
                            <a href="{{ route('events.edit', $event->id) }}" class="edit-event">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil">
                                    <path
                                        d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                class="delete-event-form" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <div class="delete-div">
                                    <button type="submit" class="delete-event">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-trash-2">
                                            <path d="M3 6h18" />
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                            <line x1="10" x2="10" y1="11" y2="17" />
                                            <line x1="14" x2="14" y1="11" y2="17" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this event?');
    }

    function showEventDetails(eventId) {
        window.location.href = `/events/${eventId}`;
    }
</script>
@endsection
