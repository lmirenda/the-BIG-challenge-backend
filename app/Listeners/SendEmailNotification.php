<?php

namespace App\Listeners;

use App\Events\DoctorHasResponded;
use App\Mail\PetitionFinishedMail;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification
{
    public function handle(DoctorHasResponded $event)
    {
        Mail::to($event->user->email)
            ->send(new PetitionFinishedMail($event->user));
    }
}
