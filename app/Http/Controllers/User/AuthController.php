<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Services\User\AuthService;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        auth()->login(
            $this->authService->register($request->validated())
        );

        return redirect()->route('home');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $this->authService->login(
            $request->validated(),
            $request->boolean('remember')
        );

        return redirect()->route('home');
    }

    public function logout()
    {
        $this->authService->logout();

        return redirect()->route('login');
    }

    public function showProfile()
    {
        return view('auth.profile', [
            'user' => auth()->user()
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->authService->updateProfile(
            auth()->user(),
            $request->validated()
        );

        return back()
            ->with('success', 'Profile updated successfully.');
    }
}
