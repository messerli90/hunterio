<?php

namespace Messerli90\Hunterio\Tests\Integration;

use Hunter;
use Illuminate\Support\Facades\Http;
use Messerli90\Hunterio\Tests\TestCase;

class GetDomainSearchTest extends TestCase
{
    /** @test */
    public function it_returns_a_response()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function ($request) {
            return Http::response(file_get_contents(__DIR__ . '/../mocks/domain-search.json'));
        });

        $response = Hunter::domainSearch()->domain('ghost.org')->get();

        $this->assertArrayHasKey('data', $response);
    }
}
