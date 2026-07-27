<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\VerifyEmailMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;
use Illuminate\Support\Facades\Log;

class SendVerificationEmailJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;
    public int $backoff = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, public string $otp)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new VerifyEmailMail($this->user, $this->otp));
    }

    public function failed(Throwable $exception): void
    {
        Log::error('Verification email failed', [

            'user_id' => $this->user->id,

            'email' => $this->user->email,

            'error' => $exception->getMessage(),

        ]);
    }
}
