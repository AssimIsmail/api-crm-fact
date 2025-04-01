<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Login route (doesn't require authentication)
Route::post('login', [AuthController::class, 'login'])->name('session.login');

// Routes that require authentication
Route::middleware('auth:api')->group(function () {
    Route::get('me', [AuthController::class, 'me'])->name('session.me');
    Route::post('logout', [AuthController::class, 'logout'])->name('session.logout');
});
