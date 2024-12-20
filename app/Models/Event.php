<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date', 'location', 'description', 'rsvp_limit'];

    // An event can have multiple RSVPs
    public function rsvps()
    {
        return $this->hasMany(RSVP::class);
    }
}
