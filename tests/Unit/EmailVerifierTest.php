<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Unit;

use Bisnow\Hunterio\EmailVerifier;
use Bisnow\Hunterio\Exceptions\InvalidRequestException;
use Bisnow\Hunterio\Tests\TestCase;

class EmailVerifierTest extends TestCase
{
    protected $email_verifier;

    protected function setUp(): void
    {
        parent::setUp();

        $this->email_verifier = new EmailVerifier('apikey');
    }

    public function test_it_throws_an__invalid_request_exception_when_email_is_missing(): void
    {
        $this->expectException(InvalidRequestException::class);

        $this->email_verifier->make();
    }

    public function test_it_builds_the_query(): void
    {
        $expected_query = [
            'email' => 'steli@close.io',
            'api_key' => 'apikey',
        ];

        $query = $this->email_verifier->email('steli@close.io')->make();

        $this->assertSame($expected_query, $query);
    }
}
