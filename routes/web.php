<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserLeaveController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LeaveBalanceController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RolePermissionController;


// AuthenticationController

Route::get('/register', [AuthenticationController::class, 'showRegisterForm'])->name('auth.register');
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('auth.login');

Route::post('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/register', [AuthenticationController::class, 'register'])->name('register');

Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

//AuthMiddleware

Route::middleware(['auth'])->group(function () {

    // DashboardController

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //UserController

    Route::resource('user', UserController::class);

    //UserLeaveController

    Route::resource('leave', UserLeaveController::class);
    Route::post('/leave/update-status/{id}', [UserLeaveController::class, 'updateStatus'])->name('leave.updateStatus');

    //Leave Controller

    Route::resource('leave-balance', LeaveBalanceController::class);

    //Role And Permissions

    Route::middleware(['can:roles_and_permission'])->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::post('assign-permission', [PermissionController::class, 'assignPermissionsToRole'])
            ->name('assignPermissionsToRole');
        Route::resource('role-permission', RolePermissionController::class);
        Route::get('role-has-permission', [RolePermissionController::class, 'showAssignForm'])
            ->name('assign.form');
    });

});

