<?php

namespace Messerli90\Hunterio\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Messerli90\Hunterio\EmailCount;
use Messerli90\Hunterio\Exceptions\InvalidRequestException;
use Messerli90\Hunterio\Tests\TestCase;

class EmailCountTest extends TestCase
{
    /** @var \Messerli90\Hunterio\EmailCount */
    protected $email_count;

    public function setUp(): void
    {
        parent::setUp();

        $this->email_count = new EmailCount();
    }

    /** @test */
    public function it_gets_instantiated_without_an_API_key()
    {
        $this->assertEquals(null, $this->email_count->__get('api_key'));
    }

    /** @test */
    public function it_sets_attributes()
    {
        $this->email_count->domain('ghost.org');
        $this->assertEquals('ghost.org', $this->email_count->domain);

        $this->email_count->company('Ghost');
        $this->assertEquals('Ghost', $this->email_count->company);

        $this->email_count->type('personal');
        $this->assertEquals('personal', $this->email_count->type);
    }

    /** @test */
    public function throws_an_InvalidRequestException_when_invalid_type_is_supplied()
    {
        $this->expectException(InvalidRequestException::class);

        $this->email_count->type('bad type');
    }

    /** @test */
    public function it_builds_the_query()
    {
        $expected_query = 'https://api.hunter.io/v2/email-count?domain=ghost.org&type=personal&';

        $query = $this->email_count->domain('ghost.org')->type('personal')->make();

        $this->assertEquals($expected_query, $query);
    }

    /** @test */
    public function it_throws_an_InvalidRequestException_when_company_or_domain_fields_are_missing()
    {
        $this->expectException(InvalidRequestException::class);

        $this->email_count->make();
    }

    /** @test */
    public function it_throws_an_InvalidRequestException_when_name_fields_are_missing()
    {
        $this->expectException(InvalidRequestException::class);

        $this->email_count->domain('ghost.org')->make();
    }

    /** @test */
    public function it_returns_a_HunterResponse()
    {
        $expected_response = file_get_contents(__DIR__ . '/../mocks/email-finder.json');

        Http::fake(function ($request) use ($expected_response) {
            return Http::response($expected_response);
        });

        $response = $this->email_count->domain('ghost.org')->get();

        $this->assertEquals(json_decode($expected_response, true)['data']['email'], $response->getData()['email']);
    }
}
