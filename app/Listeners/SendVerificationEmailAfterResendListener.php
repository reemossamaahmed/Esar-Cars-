<?php

namespace App\Listeners;

use App\Events\VerificationEmailResentEvent;
use App\Jobs\SendVerificationEmailJob;
class SendVerificationEmailAfterResendListener
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
    public function handle(VerificationEmailResentEvent $event): void
    {
        SendVerificationEmailJob::dispatch($event->user, $event->verification->otp);
    }
}
