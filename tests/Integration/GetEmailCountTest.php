<?php

namespace Messerli90\Hunterio\Tests\Integration;

use Hunter;
use Messerli90\Hunterio\Tests\TestCase;

class GetEmailCountTest extends TestCase
{
    /** @test */
    public function it_returns_a_response_with_domain()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        $response = Hunter::emailCount()->domain('ghost.org')->get();

        $this->assertArrayHasKey('data', $response);
    }

    /** @test */
    public function it_returns_a_response_with_company()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        $response = Hunter::emailCount()->company('Ghost')->get();

        $this->assertArrayHasKey('data', $response);
    }

    /** @test */
    public function it_assumes_domain_when_passing_a_constructor()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        $response = Hunter::emailCount('ghost.org');

        $this->assertArrayHasKey('data', $response);
    }
}
