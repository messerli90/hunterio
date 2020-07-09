<?php

namespace Messerli90\Hunterio\Tests\Integration;

use Hunter;
use Illuminate\Support\Facades\Http;
use Messerli90\Hunterio\Tests\TestCase;

class GetEmailFinderTest extends TestCase
{
    /** @test */
    public function it_returns_a_response()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function () {
            return Http::response(file_get_contents(__DIR__ . '/../mocks/email-finder.json'));
        });

        $response = Hunter::emailFinder()->domain('ghost.org')->name('John Doe')->get();

        $this->assertArrayHasKey('data', $response);
    }

    /** @test */
    public function it_assumes_domain_when_argument_passed()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function () {
            return Http::response(file_get_contents(__DIR__ . '/../mocks/email-finder.json'));
        });

        $response = Hunter::emailFinder('ghost.org')->name('John Doe')->get();

        $this->assertArrayHasKey('data', $response);
    }
}
