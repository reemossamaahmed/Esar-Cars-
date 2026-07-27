<?php

namespace App\Listeners;

use App\Events\PasswordResetRequestedEvent;
use App\Jobs\SendPasswordResetEmailJob;

class SendPasswordResetEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PasswordResetRequestedEvent $event): void
    {
        SendPasswordResetEmailJob::dispatch(
            $event->user,
            $event->otp->otp
        );
    }
}
