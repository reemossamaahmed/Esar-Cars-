<?php

namespace App\Services;

use App\Models\User;
use Google\Client as GoogleClient;
use Illuminate\Support\Str;
use App\Enums\UserStatus;

class GoogleAuthService
{

    private function verifyGoogleToken(string $idToken): array
    {
        $client = new GoogleClient([
            'client_id' => config('services.google.client_id'),
        ]);

        $payload = $client->verifyIdToken($idToken);

        if (!$payload) {
            throw new \Exception(__('auth.invalid_google_token'));
        }

        if (!isset($payload['email'])) {
            throw new \Exception(__('auth.google_email_not_found'));
        }

        if (!($payload['email_verified'] ?? false)) {
            throw new \Exception(__('auth.google_email_not_verified'));
        }

        return [
            'google_id' => $payload['sub'],
            'email'     => $payload['email'],
            'name'      => $payload['name'] ?? 'Google User',
            'avatar'    => $payload['picture'] ?? null,
        ];

    }

    private function linkGoogleAccount(User $user, array $googleData): User
    {
        $user->fill([

            'google_id' => $user->google_id ?? $googleData['google_id'],

            'provider' => 'google',

            'avatar' => $googleData['avatar'],

        ]);

        $user->save();

        return $user->fresh();
    }

    private function activateGoogleAccount(User $user, array $googleData): User
    {
        $user->fill([

            'google_id' => $googleData['google_id'],

            'provider' => 'google',

            'avatar' => $googleData['avatar'],

            'status' => UserStatus::ACTIVE,

            'email_verified_at' => now(),

        ]);

        $user->save();

        return $user->fresh();
    }

    private function handleExistingUser(User $user, array $googleData): User
    {
        return match ($user->status) {

            UserStatus::ACTIVE
                => $this->linkGoogleAccount($user, $googleData),

            UserStatus::PENDING
                => $this->activateGoogleAccount($user, $googleData),

            UserStatus::INACTIVE
                => throw new \Exception(
                    __('auth.account_inactive')
                ),

            UserStatus::SUSPENDED
                => throw new \Exception(
                    __('auth.account_suspended')
                ),
        };
    }

    private function findUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    private function createGoogleUser(array $googleData): User
    {
        $user = User::create([

            'name' => $googleData['name'],

            'email' => $googleData['email'],

            'password' => Str::random(32),

            'google_id' => $googleData['google_id'],

            'provider' => 'google',

            'avatar' => $googleData['avatar'],

            'status' => UserStatus::ACTIVE,

            'email_verified_at' => now(),

        ]);

        $user->assignRole('renter');

        return $user->fresh();
    }

    private function createToken(User $user): string
    {
        return $user
            ->createToken('google-auth')
            ->plainTextToken;
    }


    public function authenticate(string $idToken): array
    {
        $payload = $this->verifyGoogleToken($idToken);

        $user = $this->findUserByEmail($payload['email']);

        if (!$user) {
            $user = $this->createGoogleUser($payload);
        } else {
            $user = $this->handleExistingUser($user, $payload);
        }

        $token = $this->createToken($user);

        return [
            'user' => $user->load('roles'),
            'token' => $token,
        ];
    }
}
