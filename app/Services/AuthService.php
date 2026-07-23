<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Enums\UserStatus;

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

}
