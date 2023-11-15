<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Unit;

use Bisnow\Hunterio\EmailFinder;
use Bisnow\Hunterio\Exceptions\InvalidRequestException;
use Bisnow\Hunterio\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class EmailFinderTest extends TestCase
{
    /** @var \Bisnow\Hunterio\EmailFinder */
    protected $email_search;

    protected function setUp(): void
    {
        parent::setUp();

        $this->email_search = new EmailFinder('apikey');
    }

    public function test_it_gets_instantiated_with_an__ap_i_key(): void
    {
        $this->assertSame('apikey', $this->email_search->__get('api_key'));
    }

    public function test_it_sets_domain_and_company_attributes(): void
    {
        $this->email_search->domain('ghost.org');
        $this->assertSame('ghost.org', $this->email_search->domain);

        $this->email_search->company('Ghost');
        $this->assertSame('Ghost', $this->email_search->company);
    }

    public function test_it_sets_the_name_attribute(): void
    {
        $this->email_search->name('Dustin Moskovitz');
        $this->assertSame('Dustin+Moskovitz', $this->email_search->full_name);
        $this->assertNull($this->email_search->first_name);
        $this->assertNull($this->email_search->last_name);

        $this->email_search->name('Dustin', 'Moskovitz');
        $this->assertNull($this->email_search->full_name);
        $this->assertSame('Dustin', $this->email_search->first_name);
        $this->assertSame('Moskovitz', $this->email_search->last_name);

        $this->email_search->name('Dustin', 'Moskovitz')->name('Dustin Moskovitz');
        $this->assertSame('Dustin+Moskovitz', $this->email_search->full_name);
        $this->assertNull($this->email_search->first_name);
        $this->assertNull($this->email_search->last_name);
    }

    public function test_it_builds_the_query(): void
    {
        $expected_query = [
            'company' => null,
            'domain' => 'ghost.org',
            'api_key' => 'apikey',
            'first_name' => 'Dustin',
            'last_name' => 'Moskovitz',
        ];

        $query = $this->email_search->domain('ghost.org')->name('Dustin', 'Moskovitz')->make();

        $this->assertSame($expected_query, $query);
    }

    public function test_it_throws_an__invalid_request_exception_when_company_or_domain_fields_are_missing(): void
    {
        $this->expectException(InvalidRequestException::class);

        $this->email_search->name('Dustin Moskovitz')->make();
    }

    public function test_it_throws_an__invalid_request_exception_when_name_fields_are_missing(): void
    {
        $this->expectException(InvalidRequestException::class);

        $this->email_search->domain('ghost.org')->make();
    }

    public function test_it_returns_a_json_response(): void
    {
        $expected_response = file_get_contents(__DIR__.'/../mocks/email-finder.json');

        Http::fake(function ($request) use ($expected_response) {
            return Http::response($expected_response);
        });

        $response = $this->email_search->domain('ghost.org')->name('Dustin')->get();

        $this->assertSame(json_decode($expected_response, true)['data']['email'], $response['data']['email']);
    }
}
