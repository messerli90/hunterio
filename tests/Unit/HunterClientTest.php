<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Unit;

use Bisnow\Hunterio\Exceptions\AuthorizationException;
use Bisnow\Hunterio\HunterClient;
use Bisnow\Hunterio\Tests\TestCase;

class HunterClientTest extends TestCase
{
    public function test_it_throws_an__authorization_exception_when_api_key_is_missing(): void
    {
        $this->expectException(AuthorizationException::class);

        new HunterClient();
    }
}
