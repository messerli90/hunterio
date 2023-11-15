<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Integration;

use Bisnow\Hunterio\Tests\TestCase;
use Hunter;
use Illuminate\Support\Facades\Http;

class GetEmailFinderTest extends TestCase
{
    public function test_it_returns_a_response(): void
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function () {
            return Http::response(file_get_contents(__DIR__.'/../mocks/email-finder.json'));
        });

        $response = Hunter::emailFinder()->domain('ghost.org')->name('John Doe')->get();

        $this->assertArrayHasKey('data', $response);
    }

    public function test_it_assumes_domain_when_argument_passed(): void
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function () {
            return Http::response(file_get_contents(__DIR__.'/../mocks/email-finder.json'));
        });

        $response = Hunter::emailFinder('ghost.org')->name('John Doe')->get();

        $this->assertArrayHasKey('data', $response);
    }
}
