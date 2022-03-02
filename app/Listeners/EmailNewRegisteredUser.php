<?php

namespace App\Listeners;

use App\Mail\RegisterNewUserMail;
use Illuminate\Support\Facades\Mail;

class EmailNewRegisteredUser
{
    public function handle(object $event)
    {
        Mail::to($event->user->email)
            ->send(new RegisterNewUserMail($event->user));
    }
}
