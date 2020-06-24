<?php

namespace Messerli90\Hunterio\Tests\Unit;

use Messerli90\Hunterio\EmailVerifier;
use Messerli90\Hunterio\Exceptions\InvalidRequestException;
use Messerli90\Hunterio\Tests\TestCase;

class EmailVerifierTest extends TestCase
{
    protected $email_verifier;

    protected function setUp(): void
    {
        parent::setUp();

        $this->email_verifier = new EmailVerifier('apikey');
    }


    /** @test */
    public function it_throws_an_InvalidRequestException_when_email_is_missing()
    {
        $this->expectException(InvalidRequestException::class);

        $this->email_verifier->make();
    }

    /** @test */
    public function it_builds_the_query()
    {
        $expected_query = [
            'email' => 'steli@close.io',
            'api_key' => 'apikey'
        ];

        $query = $this->email_verifier->email('steli@close.io')->make();

        $this->assertEquals($expected_query, $query);
    }
}
