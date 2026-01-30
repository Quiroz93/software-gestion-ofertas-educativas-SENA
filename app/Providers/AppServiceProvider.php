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
        // Configure pagination to use Bootstrap 5 custom view
        \Illuminate\Pagination\Paginator::defaultView('vendor.pagination.bootstrap-5');
        
        // Load custom helpers
        if (file_exists(app_path('Helpers/helpers.php'))) {
            require_once app_path('Helpers/helpers.php');
        }
    }
}
