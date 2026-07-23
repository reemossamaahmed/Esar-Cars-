<?php

namespace App\Services;

use App\Models\User;
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

            $user = User::create([

                'name'=>$data['name'],

                'phone'=>$data['phone'] ?? null,

                'email'=>$data['email'],

                'password'=>$data['password'],

                'status' => UserStatus::ACTIVE,

            ]);


            $user->assignRole('renter');


            $token = $user->createToken(
                'auth-token'
            )->plainTextToken;


            return [
                'user'=>$user,
                'token'=>$token
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

}
