<?php

namespace App\Providers;

use App\Services\ApplicationService;
use Illuminate\Support\ServiceProvider;

class ApplicationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ApplicationService::class, function ($app) {
            return new ApplicationService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
