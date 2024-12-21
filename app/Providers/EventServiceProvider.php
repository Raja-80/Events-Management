<?php

namespace App\Providers;

use App\Events\UserAction;
use App\Listeners\UserCreated;
use App\Listeners\UserDeleted;
use App\Listeners\UserUpdated;
use App\Events\UserCreatedEvent;
use App\Events\UserDeletedEvent;
use App\Events\UserUpdatedEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreatedEvent::class => [
                UserCreated::class],

        UserDeletedEvent::class => [
                UserDeleted::class,],
                
        UserUpdatedEvent::class => [
                UserUpdated::class,],

          
            // Add other listeners here
        
    ];
   
    

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
