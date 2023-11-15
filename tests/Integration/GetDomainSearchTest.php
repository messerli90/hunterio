<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Integration;

use Bisnow\Hunterio\Tests\TestCase;
use Hunter;
use Illuminate\Support\Facades\Http;

class GetDomainSearchTest extends TestCase
{
    public function test_it_returns_a_response(): void
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function ($request) {
            return Http::response(file_get_contents(__DIR__.'/../mocks/domain-search.json'));
        });

        $response = Hunter::domainSearch()->domain('ghost.org')->get();

        $this->assertArrayHasKey('data', $response);
    }

    public function test_it_assumes_domain_and_makes_request_when_constructor_is_set(): void
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function ($request) {
            return Http::response(file_get_contents(__DIR__.'/../mocks/domain-search.json'));
        });

        $response = Hunter::domainSearch('ghost.org');

        $this->assertArrayHasKey('data', $response);
    }
}
