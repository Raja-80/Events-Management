<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    // A user can RSVP for multiple events
    public function rsvps()
    {
        return $this->hasMany(RSVP::class);
    }

    /**
     * Hide attributes when serializing.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
