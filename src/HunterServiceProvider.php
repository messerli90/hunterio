<?php

declare(strict_types=1);

namespace Bisnow\Hunterio;

use Bisnow\Hunterio\Exceptions\AuthorizationException;
use Illuminate\Support\ServiceProvider;

class HunterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('hunter.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->bind(Hunter::class, function () {
            $api_key = $this->getConfig();

            return new Hunter($api_key);
        });

        $this->app->alias(Hunter::class, 'hunterio');
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
