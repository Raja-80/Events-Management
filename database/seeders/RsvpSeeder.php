<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rsvp;
use App\Models\User;
use App\Models\Event;

class RsvpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve the first user and the first event from the database
        $user = User::skip(1)->first();
        $event = Event::first();

        // Create an RSVP for the user and event
        Rsvp::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);
    }
}
