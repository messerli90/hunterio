<?php

namespace Messerli90\Hunterio;

use Illuminate\Support\ServiceProvider;

class HunterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('hunterio.php'),
            ], 'config');

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'hunterio');

        // Register the main class to use with the facade
        $this->app->singleton('hunter', function () {
            return new Hunter(config('services.hunter.key'));
        });
        $this->app->singleton('hunter-domain-search', function () {
            return new DomainSearch(config('services.hunter.key'));
        });
    }
}
