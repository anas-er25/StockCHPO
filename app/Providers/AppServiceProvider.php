<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\AdminPolicy;
use App\Policies\SubAdminPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(User::class, AdminPolicy::class);
        // Register SubAdminPolicy for specific models
        Gate::policy(User::class, SubAdminPolicy::class);

        // Define specific gates for admin-only features
        Gate::define('manage-users', function (User $user) {
            return $user->role === User::ROLE_ADMIN;
        });

        Gate::define('view-activity-logs', function (User $user) {
            return $user->role === User::ROLE_ADMIN;
        });
        Gate::define('delete', function (User $user) {
            // Only admins can delete
            return $user->role === User::ROLE_ADMIN;
        });
    }
}
