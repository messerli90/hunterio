<?php

namespace Messerli90\Hunterio;

use Illuminate\Support\ServiceProvider;
use Zttp\Zttp;

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
            $client = new Zttp;
            return new DomainSearch($client, $api_key);
        });

        $this->app->bind(EmailSearch::class, function () {
            $api_key = config('services.hunter.key');
            $client = new Zttp;
            return new EmailSearch($client, $api_key);
        });

        $this->app->alias(DomainSearch::class, 'hunter-domain-search');
        $this->app->alias(EmailSearch::class, 'hunter-email-search');
    }
}
