<?php

namespace App\Listeners;

use App\Events\RegisteredUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;

class EmailRegisteredUser
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RegisteredUser  $event
     * @return void
     */
    public function handle(RegisteredUser $event)
    {
        //Mail::to($event->registeredUser['email'])->send(new UserRegistered($event->registeredUser));
    }
}
