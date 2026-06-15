<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthService
{
    public function login(array $credentials, bool $remember = false): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    public function register(array $data): User
    {
        $user = User::create($data);

        Http::post(env('SLACK_WEBHOOK_URL'), [
            'text' => "🎉 New User Registered!\n👤 Name: {$user->name}\n📧 Email: {$user->email}"
        ]);

        return $user;
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function updateProfile(User $user, array $data): User
    {
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return $user->fresh();
    }
}
