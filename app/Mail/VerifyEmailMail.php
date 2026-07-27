<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user, public string $otp)
    {
    }

    public function build()
    {
        return $this
            ->subject('Verify Your Email Address')
            ->view('emails.verify-email');
    }
}
