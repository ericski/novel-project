<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\ProjectUpdate;
use App\Models\User;
use App\Observers\ProjectObserver;
use App\Observers\ProjectUpdateObserver;
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
        Gate::define('viewPulse', function (User $user) {
            return $user->is_admin;
        });

        // Register observers
        Project::observe(ProjectObserver::class);
        ProjectUpdate::observe(ProjectUpdateObserver::class);
    }
}
