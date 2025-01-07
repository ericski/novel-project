<?php

namespace App\Providers;

use App\Models\Flag;
use App\Nova\BannedWord;
use App\Nova\DiscordInvite;
use App\Nova\Event;
use App\Nova\Project;
use App\Nova\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::initialPath('/resources/users');

        Nova::mainMenu(fn ($request) => [
            MenuSection::resource(User::class)
                ->icon('user-group')
                ->withBadgeIf(
                    fn() => Flag::where('flaggable_type', \App\Models\User::class)
                        ->distinct('flaggable_id')
                        ->count(),
                    'danger',
                    fn() => Flag::where('flaggable_type', \App\Models\User::class)
                        ->distinct('flaggable_id')
                        ->count() > 0
                ),
            MenuSection::resource(Project::class)
                ->icon('briefcase')
                ->withBadgeIf(
                    fn() => Flag::where('flaggable_type', \App\Models\Project::class)
                        ->distinct('flaggable_id')
                        ->count(),
                    'danger',
                    fn() => Flag::where('flaggable_type', \App\Models\Project::class)
                        ->distinct('flaggable_id')
                        ->count() > 0
                ),
            MenuSection::resource(BannedWord::class)->icon('ban'),
            MenuSection::resource(DiscordInvite::class)
                ->icon('link')
                ->withBadgeIf(fn() => DiscordInvite::$model::where('sent', false)->count(),
                    'info',
                    fn() => DiscordInvite::$model::where('sent', false)->count() > 0
                ),
            MenuSection::resource(Event::class)->icon('calendar'),
        ]);
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->is_admin;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }
}
