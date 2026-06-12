<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\Admin\AdminAuthService;

class AuthController extends Controller
{
    public function __construct(
        protected AdminAuthService $authService
    ) {}

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $this->authService->login(
            $request->validated(),
            $request->boolean('remember')
        );

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        $this->authService->logout();

        return redirect()->route('admin.login');
    }
}
