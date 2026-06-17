<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Services\User\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function show(): View
    {
        return view('auth.profile', [
            'user' => auth()->user(),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->authService->updateProfile(
            auth()->user(),
            $request->validated()
        );

        return back()->with('success', 'Profile updated successfully.');
    }
}
