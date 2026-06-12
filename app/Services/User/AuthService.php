<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login(array $newUser, bool $remember = false): bool
    {
        return Auth::attempt($newUser, $remember);
    }

    public function register(array $data): User
    {
        return User::create($data);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function updateProfile(User $user, array $data): User
    {
        $user->update($data);

        return $user->fresh();
    }
}
