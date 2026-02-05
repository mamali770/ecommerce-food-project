<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Gate::define('admin', function(User $user) {
            $roleNames = $user->roles()->pluck('name')->toArray();

            return in_array('ادمین', $roleNames);
        });
        Gate::define('author', function(User $user) {
            $roleNames = $user->roles()->pluck('name')->toArray();

            return in_array('نویسنده', $roleNames);
        });
        Gate::define('financial', function(User $user) {
            $roleNames = $user->roles()->pluck('name')->toArray();

            return in_array('مالی', $roleNames);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
