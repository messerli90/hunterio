<?php

namespace Messerli90\Hunterio\Tests\Unit;

use Messerli90\Hunterio\Exceptions\AuthorizationException;
use Messerli90\Hunterio\HunterClient;
use Messerli90\Hunterio\Tests\TestCase;

class HunterClientTest extends TestCase
{
    /** @test */
    public function it_throws_an_AuthorizationException_when_api_key_is_missing()
    {
        $this->expectException(AuthorizationException::class);

        new HunterClient();
    }
}
