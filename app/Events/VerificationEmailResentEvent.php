<?php

namespace App\Events;

use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class VerificationEmailResentEvent implements ShouldHandleEventsAfterCommit
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public User $user, public EmailVerification $verification)
    {
    }
}
