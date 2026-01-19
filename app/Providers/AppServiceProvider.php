<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SystemBootstrapService; // ✅ IMPORT CORRECTO

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SystemBootstrapService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
