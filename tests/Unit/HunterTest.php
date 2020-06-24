<?php

namespace Messerli90\Hunterio\Tests\Unit;

use Messerli90\Hunterio\Hunter;
use Illuminate\Support\Facades\Http;
use Messerli90\Hunterio\DomainSearch;
use Messerli90\Hunterio\Exceptions\AuthorizationException;
use Messerli90\Hunterio\Exceptions\InvalidRequestException;
use Messerli90\Hunterio\Exceptions\UsageException;
use Messerli90\Hunterio\Tests\TestCase;

class HunterTest extends TestCase
{
    /** @var \Messerli90\Hunterio\DomainSearch */
    protected $hunter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hunter = new Hunter('apikey');
    }

    /** @test */
    public function it_throws_a_AuthorizationException_when_api_key_provided_is_invalid()
    {
        $this->expectException(AuthorizationException::class);

        $error_response_mock = file_get_contents(__DIR__ . '/../mocks/error.json');
        Http::fake(function () use ($error_response_mock) {
            return Http::response($error_response_mock, 401);
        });

        $domain_search = new DomainSearch('apikey');
        $domain_search->company('Ghost')->get();
    }

    /** @test */
    public function throws_UsageException_when_status_returns_403()
    {
        $this->expectException(UsageException::class);

        $error_response_mock = file_get_contents(__DIR__ . '/../mocks/error.json');
        Http::fake(function () use ($error_response_mock) {
            return Http::response($error_response_mock, 403);
        });

        $domain_search = new DomainSearch('apikey');
        $domain_search->company('Ghost')->get();
    }

    /** @test */
    public function throws_UsageException_when_status_returns_429()
    {
        $this->expectException(UsageException::class);

        $error_response_mock = file_get_contents(__DIR__ . '/../mocks/error.json');
        Http::fake(function () use ($error_response_mock) {
            return Http::response($error_response_mock, 429);
        });

        $domain_search = new DomainSearch('apikey');
        $domain_search->company('Ghost')->get();
    }

    /** @test */
    public function throws_InvalidRequestException_for_all_other_error_cods()
    {
        $this->expectException(InvalidRequestException::class);

        $error_response_mock = file_get_contents(__DIR__ . '/../mocks/error.json');
        Http::fake(function () use ($error_response_mock) {
            return Http::response($error_response_mock, 400);
        });

        $domain_search = new DomainSearch('apikey');
        $domain_search->company('Ghost')->get();
    }

    /** @test */
    public function it_cleans_up_null_values_from_query_params()
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
            'api_key' => 'apikey'
        ];

        $expected_query_params = [
            'domain' => 'ghost.org',
            'limit' => 10,
            'api_key' => 'apikey'
        ];

        $this->assertEquals($expected_query_params, $hunter->make());
    }

    /** @test */
    public function it_returns_a_DomainSearch_model()
    {
        $hunter = new Hunter('apikey');

        $this->assertInstanceOf(\Messerli90\Hunterio\DomainSearch::class, $hunter->domainSearch());
    }

    /** @test */
    public function it_returns_a_EmailFinder_model()
    {
        $hunter = new Hunter('apikey');

        $this->assertInstanceOf(\Messerli90\Hunterio\EmailFinder::class, $hunter->emailFinder());
    }

    /** @test */
    public function it_returns_a_EmailCount_model()
    {
        $hunter = new Hunter('apikey');

        $this->assertInstanceOf(\Messerli90\Hunterio\EmailCount::class, $hunter->emailCount());
    }

    /** @test */
    public function it_returns_a_EmailVerifier_model()
    {
        $hunter = new Hunter('apikey');

        $this->assertInstanceOf(\Messerli90\Hunterio\EmailVerifier::class, $hunter->emailVerifier());
    }
}
