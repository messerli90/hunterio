<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Integration;

use Bisnow\Hunterio\Tests\TestCase;
use Hunter;
use Illuminate\Support\Facades\Http;

class GetEmailVerifierTest extends TestCase
{
    public function test_it_returns_a_response(): void
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function () {
            return Http::response(file_get_contents(__DIR__.'/../mocks/email-verifier.json'));
        });

        $response = Hunter::emailVerifier()->verify('steli@close.io');

        $this->assertArrayHasKey('data', $response);
    }

    public function test_it_returns_a_response_with_a_contructor_set(): void
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function () {
            return Http::response(file_get_contents(__DIR__.'/../mocks/email-verifier.json'));
        });

        $response = Hunter::verifyEmail('steli@close.io');

        $this->assertArrayHasKey('data', $response);
    }
}
