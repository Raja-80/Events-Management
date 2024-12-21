<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RsvpController;


Auth::routes();
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    } else {
        return redirect()->route('login');
    }
})->name('home');

Route::get('/home', [EventController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->group(function () {

    // Authenticated Users
    Route::get('/{event}', [EventController::class, 'show'])->name('events.show'); // Show event details
    Route::post('/{event}/rsvp', [RsvpController::class, 'store'])->name('events.rsvp'); // RSVP for an event

    // Admin Routes (these routes are already protected by 'auth' and 'admin')
    Route::get('/create', [EventController::class, 'create'])->name('events.create'); // Create a new event
    Route::post('/', [EventController::class, 'store'])->name('events.store');
    Route::get('/{event}/edit', [EventController::class, 'edit'])->name('events.edit'); // Edit event
    Route::put('/{event}', [EventController::class, 'update'])->name('events.update'); // Update event
    Route::delete('/{event}', [EventController::class, 'destroy'])->name('events.destroy'); // Delete event

});