@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold mb-6">All Events</h1>

        <div>
            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('events.create') }}">Create New Event</a>
                @endif
            @endauth
        </div>

        {{-- Filters --}}
        <div class="flex space-x-4 mb-6">
            <form action="#" method="GET" class="flex space-x-2">
                <input type="text" name="location" placeholder="Filter by location" class="px-4 py-2 border rounded-md">
                <input type="date" name="date" class="px-4 py-2 border rounded-md">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Filter</button>
            </form>
        </div>

        {{-- Event List --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <h2 class="text-2xl font-semibold">{{ $event->name }}</h2>
                    <p><strong>Date:</strong> {{ $event->date }}</p>
                    <p><strong>Location:</strong> {{ $event->location }}</p>
                    <p>{{ Str::limit($event->description, 100) }}</p>

                    <a href="{{ route('events.show', $event->id) }}" class="text-blue-500 hover:underline mt-2 block">View
                        Details</a>

                    @if (auth()->user() && auth()->user()->role === 'admin')
                        <div class="mt-2">
                            <a href="{{ route('events.edit', $event->id) }}"
                                class="bg-yellow-500 text-black px-4 py-2 rounded-md">Edit</a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
