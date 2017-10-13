<?php

namespace App\Providers;

use App\Services\VideoService;
use Illuminate\Support\ServiceProvider;

class VideoProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(VideoService::class, function ($app) {
            return new VideoService();
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
