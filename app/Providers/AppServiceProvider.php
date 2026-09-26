<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS in production / when deployed behind SSL reverse proxy (Render, Cloudflare, etc.)
        if (app()->isProduction() || str_starts_with(config('app.url', ''), 'https://') || env('FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }
    }
}
