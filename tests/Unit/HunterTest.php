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

    public function setUp(): void
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
    public function it_returns_a_email_count_model()
    {
        $hunter = new Hunter('apikey');

        $hunter->emailCount()->company('ghost')->make();
    }
}
