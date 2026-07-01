<?php

namespace App\Providers;

use App\Contracts\GeoLocationServiceInterface;
use App\Services\GeoLocationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            GeoLocationServiceInterface::class,
            GeoLocationService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
