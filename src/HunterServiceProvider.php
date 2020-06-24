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
        // $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'hunterio');


        $this->app->bind(DomainSearch::class, function () {
            $api_key = config('services.hunter.key');
            return new DomainSearch($api_key);
        });

        $this->app->bind(EmailFinder::class, function () {
            $api_key = config('services.hunter.key');
            return new EmailFinder($api_key);
        });

        $this->app->bind(EmailCount::class, function () {
            $api_key = config('services.hunter.key');
            return new EmailCount($api_key);
        });

        $this->app->alias(DomainSearch::class, 'hunter-domain-search');
        $this->app->alias(EmailFinder::class, 'hunter-email-finder');
        $this->app->alias(EmailCount::class, 'hunter-email-count');
    }
}
