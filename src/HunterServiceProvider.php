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
