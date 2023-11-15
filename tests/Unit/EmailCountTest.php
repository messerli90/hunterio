<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Unit;

use Bisnow\Hunterio\EmailCount;
use Bisnow\Hunterio\Exceptions\InvalidRequestException;
use Bisnow\Hunterio\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class EmailCountTest extends TestCase
{
    /** @var \Bisnow\Hunterio\EmailCount */
    protected $email_count;

    protected function setUp(): void
    {
        parent::setUp();

        $this->email_count = new EmailCount();
    }

    public function test_it_gets_instantiated_without_an__ap_i_key(): void
    {
        $this->assertNull($this->email_count->__get('api_key'));
    }

    public function test_it_sets_attributes(): void
    {
        $this->email_count->domain('ghost.org');
        $this->assertSame('ghost.org', $this->email_count->domain);

        $this->email_count->company('Ghost');
        $this->assertSame('Ghost', $this->email_count->company);

        $this->email_count->type('personal');
        $this->assertSame('personal', $this->email_count->type);
    }

    public function test_throws_an__invalid_request_exception_when_invalid_type_is_supplied(): void
    {
        $this->expectException(InvalidRequestException::class);

        $this->email_count->type('bad type');
    }

    public function test_it_builds_the_query(): void
    {
        $expected_query = [
            'company' => null,
            'domain' => 'ghost.org',
            'type' => 'personal',
        ];

        $query = $this->email_count->domain('ghost.org')->type('personal')->make();

        $this->assertSame($expected_query, $query);
    }

    public function test_it_throws_an__invalid_request_exception_when_company_or_domain_fields_are_missing(): void
    {
        $this->expectException(InvalidRequestException::class);

        $this->email_count->make();
    }

    public function test_it_returns_a_json_response(): void
    {
        $expected_response = file_get_contents(__DIR__.'/../mocks/email-finder.json');

        Http::fake(function ($request) use ($expected_response) {
            return Http::response($expected_response);
        });

        $response = $this->email_count->domain('ghost.org')->get();

        $this->assertSame(json_decode($expected_response, true)['data']['email'], $response['data']['email']);
    }
}
