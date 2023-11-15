<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Unit;

use Bisnow\Hunterio\DomainSearch;
use Bisnow\Hunterio\Exceptions\AuthorizationException;
use Bisnow\Hunterio\Exceptions\InvalidRequestException;
use Bisnow\Hunterio\Exceptions\UsageException;
use Bisnow\Hunterio\Hunter;
use Bisnow\Hunterio\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class HunterTest extends TestCase
{
    /** @var \Bisnow\Hunterio\DomainSearch */
    protected $hunter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hunter = new Hunter('apikey');
    }

    public function test_it_throws_a__authorization_exception_when_api_key_provided_is_invalid(): void
    {
        $this->expectException(AuthorizationException::class);

        $error_response_mock = file_get_contents(__DIR__.'/../mocks/error.json');
        Http::fake(function () use ($error_response_mock) {
            return Http::response($error_response_mock, 401);
        });

        $domain_search = new DomainSearch('apikey');
        $domain_search->company('Ghost')->get();
    }

    public function test_throws__usage_exception_when_status_returns_403(): void
    {
        $this->expectException(UsageException::class);

        $error_response_mock = file_get_contents(__DIR__.'/../mocks/error.json');
        Http::fake(function () use ($error_response_mock) {
            return Http::response($error_response_mock, 403);
        });

        $domain_search = new DomainSearch('apikey');
        $domain_search->company('Ghost')->get();
    }

    public function test_throws__usage_exception_when_status_returns_429(): void
    {
        $this->expectException(UsageException::class);

        $error_response_mock = file_get_contents(__DIR__.'/../mocks/error.json');
        Http::fake(function () use ($error_response_mock) {
            return Http::response($error_response_mock, 429);
        });

        $domain_search = new DomainSearch('apikey');
        $domain_search->company('Ghost')->get();
    }

    public function test_throws__invalid_request_exception_for_all_other_error_cods(): void
    {
        $this->expectException(InvalidRequestException::class);

        $error_response_mock = file_get_contents(__DIR__.'/../mocks/error.json');
        Http::fake(function () use ($error_response_mock) {
            return Http::response($error_response_mock, 400);
        });

        $domain_search = new DomainSearch('apikey');
        $domain_search->company('Ghost')->get();
    }

    public function test_it_cleans_up_null_values_from_query_params(): void
    {
        $hunter = new Hunter('apikey');
        $hunter->query_params = [
            'company' => null,
            'domain' => 'ghost.org',
            'type' => null,
            'department' => null,
            'seniority' => null,
            'limit' => 10,
            'offset' => null,
            'api_key' => 'apikey',
        ];

        $expected_query_params = [
            'domain' => 'ghost.org',
            'limit' => 10,
            'api_key' => 'apikey',
        ];

        $this->assertSame($expected_query_params, $hunter->make());
    }

    public function test_it_returns_a__domain_search_model(): void
    {
        $hunter = new Hunter('apikey');

        $this->assertInstanceOf(\Bisnow\Hunterio\DomainSearch::class, $hunter->domainSearch());
    }

    public function test_it_returns_a__email_finder_model(): void
    {
        $hunter = new Hunter('apikey');

        $this->assertInstanceOf(\Bisnow\Hunterio\EmailFinder::class, $hunter->emailFinder());
    }

    public function test_it_returns_a__email_count_model(): void
    {
        $hunter = new Hunter('apikey');

        $this->assertInstanceOf(\Bisnow\Hunterio\EmailCount::class, $hunter->emailCount());
    }

    public function test_it_returns_a__email_verifier_model(): void
    {
        $hunter = new Hunter('apikey');

        $this->assertInstanceOf(\Bisnow\Hunterio\EmailVerifier::class, $hunter->emailVerifier());
    }
}
