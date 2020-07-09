<?php

namespace Messerli90\Hunterio\Tests\Integration;

use Hunter;
use Illuminate\Support\Facades\Http;
use Messerli90\Hunterio\Tests\TestCase;

class GetEmailVerifierTest extends TestCase
{
    /** @test */
    public function it_returns_a_response()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function () {
            return Http::response(file_get_contents(__DIR__ . '/../mocks/email-verifier.json'));
        });

        $response = Hunter::emailVerifier()->verify('steli@close.io');

        $this->assertArrayHasKey('data', $response);
    }

    /** @test */
    public function it_returns_a_response_with_a_contructor_set()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function () {
            return Http::response(file_get_contents(__DIR__ . '/../mocks/email-verifier.json'));
        });

        $response = Hunter::verifyEmail('steli@close.io');

        $this->assertArrayHasKey('data', $response);
    }
}
