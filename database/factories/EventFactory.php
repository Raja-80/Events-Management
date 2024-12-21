<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3), // Random event name
            'date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'), // Random future date
            'location' => $this->faker->city, // Random city
            'description' => $this->faker->paragraph, // Random description
            'rsvp_limit' => $this->faker->numberBetween(10, 100), // Random RSVP limit
        ];
    }
}
