<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserLeaveRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\LeaveBalanceRepository;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\RoleRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\RolePermissionRepository;
use App\Repositories\UserLeaveRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\LeaveBalanceRepositoryInterface;
use App\Repositories\RolePermissionRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserLeaveRepositoryInterface::class, UserLeaveRepository::class);
        $this->app->bind(LeaveBalanceRepositoryInterface::class, LeaveBalanceRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RolePermissionRepositoryInterface::class, RolePermissionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
