<?php

namespace App\Services;

use App\Models\User;

class AuthService
{

    public function register(array $data): array
    {

        $user = User::create([

            'name'=>$data['name'],

            'phone'=>$data['phone'] ?? null,

            'email'=>$data['email'],

            'password'=>$data['password'],

            'status'=>'active',

        ]);


        $user->assignRole('renter');


        $token = $user->createToken(
            'auth-token'
        )->plainTextToken;


        return [
            'user'=>$user,
            'token'=>$token
        ];
    }

}
