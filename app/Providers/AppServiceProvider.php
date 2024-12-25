<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;
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
    // Trust all proxies
    Request::setTrustedProxies(['**'], Request::HEADER_X_FORWARDED_ALL);

    // Force HTTPS URLs
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }
    }
}
