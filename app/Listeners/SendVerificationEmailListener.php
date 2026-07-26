<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Mail\VerifyEmailMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendVerificationEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegisteredEvent $event): void
    {
        Mail::to($event->user->email)
            ->send(
                new VerifyEmailMail(
                    $event->verification->otp
                )
            );
    }
}
