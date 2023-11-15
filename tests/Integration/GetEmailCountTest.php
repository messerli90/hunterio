<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Integration;

use Bisnow\Hunterio\Tests\TestCase;
use Hunter;

class GetEmailCountTest extends TestCase
{
    public function test_it_returns_a_response_with_domain(): void
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        $response = Hunter::emailCount()->domain('ghost.org')->get();

        $this->assertArrayHasKey('data', $response);
    }

    public function test_it_returns_a_response_with_company(): void
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        $response = Hunter::emailCount()->company('Ghost')->get();

        $this->assertArrayHasKey('data', $response);
    }

    public function test_it_assumes_domain_when_passing_a_constructor(): void
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        $response = Hunter::emailCount('ghost.org');

        $this->assertArrayHasKey('data', $response);
    }
}
