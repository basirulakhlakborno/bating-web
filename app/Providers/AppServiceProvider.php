<?php

namespace App\Providers;

use App\Services\SiteLayoutData;
use Illuminate\Support\Facades\View;
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
        View::composer(
            [
                'components.desktop-nav',
                'components.navigation-drawer',
                'components.footer',
                'home',
            ],
            function ($view): void {
                static $payload = null;
                $payload ??= SiteLayoutData::shared();
                $view->with($payload);
            }
        );
    }
}
