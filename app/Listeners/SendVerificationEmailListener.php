<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Jobs\SendVerificationEmailJob;

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
        SendVerificationEmailJob::dispatch(
            $event->user,
            $event->verification->otp
        );
    }
}
