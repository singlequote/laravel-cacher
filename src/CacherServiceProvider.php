<?php

namespace SingleQuote\Cacher;

use Illuminate\Support\ServiceProvider;

class CacherServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //php artisan vendor:publish --tag=laravel-cacher-config
        $this->publishes([
            __DIR__.'/../config/laravel-cacher.php' => config_path('laravel-cacher.php'),
        ], 'laravel-cacher-config');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('Cacher', 'SingleQuote\Cacher\Cacher');

        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-cacher.php',
            'laravel-cacher'
        );
    }
}
