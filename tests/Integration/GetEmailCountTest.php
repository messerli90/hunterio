<?php

namespace Messerli90\Hunterio\Tests\Integration;

use EmailCount;
use Illuminate\Support\Facades\Http;
use Messerli90\Hunterio\Exceptions\AuthorizationException;
use Messerli90\Hunterio\HunterResponse;
use Messerli90\Hunterio\Tests\TestCase;

class GetEmailCountTest extends TestCase
{
    /** @test */
    public function it_returns_a_response()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        $response = EmailCount::domain('ghost.org')->get();

        $this->assertInstanceOf(HunterResponse::class, $response);
    }
}
