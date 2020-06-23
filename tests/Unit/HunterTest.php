<?php

namespace Messerli90\Hunterio\Tests\Unit;

use Messerli90\Hunterio\Hunter;
use Illuminate\Support\Facades\Http;
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
        $domain_search = new DomainSearch('bad key');

        $mocked_response = json_encode(file_get_contents(__DIR__ . '/../mocks/domain-search.json'), true);
        Http::fake([
            '*/domain-search' => Http::response($mocked_response, 200)
        ]);

        //     $this->domain_search->company('Ghost')->get($mock);
    }
}


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
