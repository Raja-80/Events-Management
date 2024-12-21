<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'password', 'role'];

    // A user can RSVP for multiple events
    public function rsvps()
    {
        return $this->hasMany(RSVP::class);
    }
}
