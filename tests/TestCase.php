<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests;

use Bisnow\Hunterio\Facades\Hunter;
use Bisnow\Hunterio\HunterServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            HunterServiceProvider::class,
        ];
    }

    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Hunter' => Hunter::class,
        ];
    }
}
