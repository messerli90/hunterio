<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Integration;

use Bisnow\Hunterio\Tests\TestCase;
use Hunter;
use Illuminate\Support\Facades\Http;

class GetAccountInfoTest extends TestCase
{
    public function test_it_returns_a_response(): void
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        Http::fake(function () {
            return Http::response(file_get_contents(__DIR__.'/../mocks/account-info.json'));
        });

        $response = Hunter::account();

        $this->assertArrayHasKey('data', $response);
    }
}
