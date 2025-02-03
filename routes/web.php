<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserLeaveController;
use App\Http\Controllers\AuthenticationController;


// AuthenticationController

Route::get('/register', [AuthenticationController::class, 'showRegisterForm'])->name('auth.register');
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('auth.login');

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/register', [AuthenticationController::class, 'register'])->name('register');

Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

//AuthMiddleware

// AuthMiddleware
Route::middleware(['auth'])->group(function () {

    // DashboardController
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('user', UserController::class);
    Route::resource('leave', UserLeaveController::class);
    Route::post('/leave/update-status/{id}', [UserLeaveController::class, 'updateStatus'])->name('leave.updateStatus');
});

