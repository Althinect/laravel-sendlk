<?php

namespace Althinect\LaravelSendlk;

use Althinect\LaravelSendlk\Console\PruneLogs;
use Illuminate\Support\ServiceProvider;

class LaravelSendlkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load package assets
         */
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-sendlk.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([
                PruneLogs::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-sendlk');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-sendlk', function () {
            return new LaravelSendlk;
        });
    }
}
