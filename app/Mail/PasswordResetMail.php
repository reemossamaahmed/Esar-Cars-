<?php

namespace App\Mail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
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
            ->subject('Reset Your Password - Esar Cars')
            ->view('emails.password-reset')
            ->with([
                'user' => $this->user,
                'otp' => $this->otp,
            ]);
    }
}
