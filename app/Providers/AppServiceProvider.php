<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\EacImporter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(EacImporter::class, function ($app) {
            return new EacImporter();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
