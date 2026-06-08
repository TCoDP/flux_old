<?php

namespace App\Providers;

use App\Services\SeoService;
use App\Services\SettingsService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SettingsService::class);
        $this->app->singleton(SeoService::class);
    }

    public function boot(): void
    {
        Paginator::useTailwind();
    }
}
