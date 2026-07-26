<?php

namespace App\Events;

use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegisteredEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public User $user, public EmailVerification $verification)
    {
    }
}
