<?php

namespace Messerli90\Hunterio;

use Illuminate\Support\ServiceProvider;
use Messerli90\Hunterio\Exceptions\AuthorizationException;

class HunterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('hunter.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        // $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'hunter');

        // $api_key = $this->getConfig();

        $this->app->bind(Hunter::class, function () {
            $api_key = $this->getConfig();
            return new Hunter($api_key);
        });

        $this->app->bind(DomainSearch::class, function () {
            $api_key = $this->getConfig();
            return new DomainSearch($api_key);
        });

        $this->app->bind(EmailFinder::class, function () {
            $api_key = $this->getConfig();
            return new EmailFinder($api_key);
        });

        $this->app->bind(EmailCount::class, function () {
            $api_key = $this->getConfig();
            return new EmailCount($api_key);
        });

        $this->app->bind(EmailVerifier::class, function () {
            $api_key = $this->getConfig();
            return new EmailVerifier($api_key);
        });

        $this->app->alias(Hunter::class, 'hunterio');
        $this->app->alias(DomainSearch::class, 'hunter-domain-search');
        $this->app->alias(EmailFinder::class, 'hunter-email-finder');
        $this->app->alias(EmailCount::class, 'hunter-email-count');
        $this->app->alias(EmailVerifier::class, 'hunter-email-verifier');
    }

    protected function getConfig()
    {
        if (config('hunter.key')) {
            return config('hunter.key');
        }
        if (config('services.hunter.key')) {
            return config('services.hunter.key');
        }
        throw new AuthorizationException('Could not find an API key.');
    }
}
