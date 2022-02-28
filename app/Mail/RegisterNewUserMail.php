<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterNewUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->markdown('email.register.register-new-user');
    }
}
