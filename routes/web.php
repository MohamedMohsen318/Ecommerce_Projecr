<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function() {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{path}', [CategoryController::class, 'show'])
    ->where('path', '.*')
    ->name('categories.show');

Route::prefix('admin')
    ->name('admin.')
    ->group(function() {
        Route::middleware('guest:admin')->group(function() {
            Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');
        });

        Route::middleware('auth:admin')->group(function() {
            Route::get('/dashboard', function() {
                return view('admin.dashboard');
            })->name('dashboard');

            Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
            Route::resource('categories', AdminCategoryController::class);
        });
    });
