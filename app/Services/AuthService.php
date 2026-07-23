<?php

namespace App\Services;

use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Enums\UserStatus;
use App\Models\PasswordOtp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;


class AuthService
{

    public function register(array $data): array
    {

        return DB::transaction(function () use ($data){

            $existingUser = User::where('email',$data['email'])->first();

            if($existingUser)
            {
                if ($existingUser->email_verified_at)
                {
                    throw ValidationException::withMessages([
                        'email' => [ __('auth.email_exists') ]
                    ]);
                }

                $this->createVerificationOtp($existingUser);

                return [
                    'user' => $existingUser,
                ];
            }


            $user = User::create([

                'name'=>$data['name'],

                'phone'=>$data['phone'] ?? null,

                'email'=>$data['email'],

                'password'=>$data['password'],

                'status' => UserStatus::PENDING,

            ]);


            $user->assignRole('renter');

            $this->createVerificationOtp($user);

            return [
                'user'=>$user
            ];
        });

    }

    public function login(array $data): array
    {

        $user = User::where('email',$data['email'])->first();

        if(!$user)
        {
            throw ValidationException::withMessages([

                'email'=> [ __('auth.invalid_credentials') ]

            ]);
        }



        if(!Hash::check($data['password'],$user->password))
        {
            throw ValidationException::withMessages([

                'email'=>[ __('auth.invalid_credentials') ]

            ]);
        }

        if ($user->status !== UserStatus::ACTIVE)
        {
            throw ValidationException::withMessages([

                'email'=>[ __('auth.account_disabled') ]

            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [

            'user'=>$user,

            'token'=>$token

        ];

    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function updateProfile(User $user, array $data): User
    {
        $user->update($data);

        return $user->refresh();
    }


    public function changePassword(User $user, array $data): void
    {

        if (!Hash::check($data['current_password'], $user->password))
        {

            throw ValidationException::withMessages([

                'current_password' => [
                    __('auth.invalid_current_password')
                ]

            ]);

        }


        $user->update([

            'password' => $data['password']

        ]);


        // Logout from all devices
        $user->tokens()->delete();

    }

    public function forgotPassword(array $data): void
    {
        $user = User::where('email', $data['email'])->first();


        if (!$user) {

            throw ValidationException::withMessages([

                'email' => [
                    __('auth.email_not_found')
                ]

            ]);

        }


        // Delete old OTPs
        PasswordOtp::where('email', $data['email'])->delete();



        // Generate OTP
        $otp = random_int(100000, 999999);



        // Store OTP hashed
        PasswordOtp::create([

            'email' => $data['email'],

            // 'otp' => Hash::make($otp),

            'otp' => $otp,

            'expires_at' => now()->addMinutes(10),

        ]);

    }

    public function resetPassword(array $data): void
    {

        $otp = PasswordOtp::where('email', $data['email'])
            ->where('used', false)
            ->latest()
            ->first();


        if (!$otp) {

            throw ValidationException::withMessages([

                'otp'=>[
                    __('auth.invalid_otp')
                ]

            ]);

        }


        if ($otp->expires_at->isPast()) {

            throw ValidationException::withMessages([

                'otp'=>[
                    __('auth.expired_otp')
                ]

            ]);

        }


        if ($otp->otp != $data['otp']) {

            throw ValidationException::withMessages([

                'otp'=>[
                    __('auth.invalid_otp')
                ]

            ]);

        }


        $user = User::where('email',$data['email'])
            ->first();


        $user->update([

            'password'=>$data['password']

        ]);


        // logout all devices
        $user->tokens()->delete();


        $otp->update([

            'used'=>true

        ]);

    }

    public function verifyEmail(array $data): void
    {
        $verification = EmailVerification::where('email', $data['email'])->latest()->first();

        if (!$verification) {

            throw ValidationException::withMessages([
                'otp' => [ __('auth.invalid_otp') ]
            ]);

        }

        if ($verification->verified) {

            throw ValidationException::withMessages([
                'email' => [ __('auth.email_already_verified')]
            ]);

        }

        if ($verification->expires_at->isPast()) {

            throw ValidationException::withMessages([

                'otp' => [ __('auth.expired_otp') ]

            ]);

        }

        if ($verification->otp != $data['otp']) {

            throw ValidationException::withMessages([

                'otp' => [ __('auth.invalid_otp') ]

            ]);

        }

        $user = User::where('email', $data['email'])->first();

        if(!$user){
            throw ValidationException::withMessages([
                'email'=>[
                    __('auth.user_not_found')
                ]
            ]);
        }

        $user->update([
            'email_verified_at' => now() ,
            'status' => UserStatus::ACTIVE
        ]);

        $verification->update([ 'verified'=>true ]);

    }


    private function createVerificationOtp(User $user): EmailVerification
    {
        EmailVerification::where('email', $user->email)->delete();


        return EmailVerification::create([

            'email' => $user->email,

            'otp' => random_int(100000, 999999),

            'expires_at' => now()->addMinutes(10),

        ]);
    }

}
