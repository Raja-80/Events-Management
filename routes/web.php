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



Route::middleware('admin-group')->group(function () {
    Route::resource('events', EventController::class);
    Route::get('/home', [EventController::class, 'index'])->name('home');
    Route::post('/{event}/rsvp', [RsvpController::class, 'store'])->name('events.rsvp'); 

});