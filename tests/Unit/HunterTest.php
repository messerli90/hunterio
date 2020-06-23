<?php




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
