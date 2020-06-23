<?php

namespace Messerli90\Hunterio\Tests;

use Illuminate\Support\Facades\Http;
use Mockery;
use Zttp\Zttp;
use PHPUnit\Framework\TestCase;
use Messerli90\Hunterio\Hunter;
use Messerli90\Hunterio\Tests\Integration\TestCase as IntegrationTestCase;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class HunterTest extends IntegrationTestCase
{
    /** @var \Illuminate\Support\Facades\Http|\Mockery\Mock */
    protected $http_client;

    /** @var \Messerli90\Hunterio\DomainSearch */
    protected $hunter;

    public function setUp(): void
    {
        parent::setUp();
        // $this->http_client = Mockery::mock(Http::class);
        // $this->http_client = Http::fake();
        $mocked_response = json_encode(file_get_contents(__DIR__ . '/../mocks/domain-search.json'), true);
        $this->http_client = Http::fake([
            '*/domain-search' => Http::response($mocked_response, 200)
        ]);

        $this->hunter = new Hunter($this->http_client, 'apikey');
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    /** @test */
    public function it_returns_a_HunterResponse_when_successful_search_is_returned()
    {
        $expected_arguments = 'https://api.hunter.io/v2/domain-search?';





        $response = $this->hunter->makeRequest($expected_arguments);

        dump($response);

        // $this->analyticsClient
        //     ->shouldReceive('performQuery')->withArgs($expectedArguments)
        //     ->once()
        //     ->andReturn([
        //         'rows' => [['20160101', 'pageTitle', '1', '2']],
        //     ]);

        // $response = $this->analytics->fetchVisitorsAndPageViews(Period::create($this->startDate, $this->endDate));
    }
}


// it('returns a HunterResponse when successful search is returned', function () {
//     $mock = mockSuccessfulDomainSearchRequest();
//     new DomainSearch($mock, $_SERVER['HUNTER_API_KEY']);

//     assertInstanceOf('Messerli90\Hunterio\HunterResponse', $this->domain_search->company('Ghost')->get($mock));
// });

// it('throws AuthorizationException when API key provided is invalid', function () {
//     $domain_search = new DomainSearch('bad key');

//     $mock = mockErrorDomainSearchRequest(401);

//     $this->domain_search->company('Ghost')->get($mock);
// })->throws(AuthorizationException::class);

// it('throws UsageException when status returns 403', function () {
//     $domain_search = new DomainSearch('bad key');

//     $mock = mockErrorDomainSearchRequest(403);

//     $this->domain_search->company('Ghost')->get($mock);
// })->throws(UsageException::class);

// it('throws UsageException when status returns 429', function () {
//     $domain_search = new DomainSearch('bad key');

//     $mock = mockErrorDomainSearchRequest(429);

//     $this->domain_search->company('Ghost')->get($mock);
// })->throws(UsageException::class);

// it('throws InvalidRequestException for other error statuses', function () {
//     $domain_search = new DomainSearch('bad key');

//     $mock = mockErrorDomainSearchRequest(400);

//     $this->domain_search->company('Ghost')->get($mock);
// })->throws(InvalidRequestException::class);
