<?php

namespace App\Events;

use App\Models\User;
use App\Models\PasswordOtp;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class PasswordResetRequestedEvent implements ShouldHandleEventsAfterCommit
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public User $user, public PasswordOtp $otp)
    {
    }
}
