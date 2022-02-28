<?php

namespace App\Listeners;

use App\Mail\RegisterNewUserMail;
use Illuminate\Support\Facades\Mail;

class EmailNewRegisteredUser
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
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        $user = $event->user;
        Mail::to($user->email)->send(new RegisterNewUserMail($user));
    }
}
