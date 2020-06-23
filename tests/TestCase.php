<?php

namespace Messerli90\Hunterio\Tests;

use Messerli90\Hunterio\Facades\DomainSearch;
use Messerli90\Hunterio\Facades\EmailSearch;
use Messerli90\Hunterio\Facades\EmailCount;
use Messerli90\Hunterio\HunterServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            HunterServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'DomainSearch' => DomainSearch::class,
            'EmailSearch' => EmailSearch::class,
            'EmailCount' => EmailCount::class,
        ];
    }
}
