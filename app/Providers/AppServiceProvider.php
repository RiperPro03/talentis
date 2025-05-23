<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('viewFilament', function ($user) {
            \Log::info('Gate check', ['user' => $user->id, 'roles' => $user->getRoleNames()]);
            return $user->hasRole('admin');
        });
    }
}
