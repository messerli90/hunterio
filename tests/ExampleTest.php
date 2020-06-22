<?php

namespace Messerli90\Hunterio\Tests;

use Orchestra\Testbench\TestCase;
use Messerli90\Hunterio\HunterServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [HunterServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
