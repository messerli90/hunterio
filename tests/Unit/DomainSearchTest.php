<?php

use Messerli90\Hunterio\DomainSearch;
use Messerli90\Hunterio\Exceptions\AuthorizationException;
use Messerli90\Hunterio\Exceptions\InvalidRequestException;

it('gets instantiated with an API key', function () {
    $domain_search = new DomainSearch('testing_api_key');
    assertEquals('testing_api_key', $domain_search->__get('api_key'));
    assertEquals(10, $domain_search->limit);
});

it('throws a AuthorizationException when no API key provided', function () {
    new DomainSearch();
})->throws(AuthorizationException::class, 'API key required');

it('sets the domain that should be searched', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->domain('ghost.org');
    assertEquals('ghost.org', $domain_search->domain);
});

it('sets the company that should be searched', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->company('Ghost');
    assertEquals('Ghost', $domain_search->company);
});

it('sets the limit attribute', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->limit(20);
    assertEquals(20, $domain_search->limit);
});

it('sets the limit attribute to 10 if number > 100 is attempted', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->limit(101);
    assertEquals(10, $domain_search->limit);
});

it('sets the offset attribute', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->offset(20);
    assertEquals(20, $domain_search->offset);
});

it('sets the type attribute', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->type('personal');
    assertEquals('personal', $domain_search->type);
    $domain_search->type('generic');
    assertEquals('generic', $domain_search->type);
});

it('throws an InvalidRequestException when invalid type is supplied', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->type('bad type');
})->throws(InvalidRequestException::class, 'Type must be either "generic" or "personal".');

it('sets the seniority attribute using a string', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->seniority('junior');
    assertEquals(['junior'], $domain_search->seniority);
});

it('sets the seniority attribute using an array', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->seniority(['junior', 'senior']);
    assertEquals(['junior', 'senior'], $domain_search->seniority);
});

it('ignores invalid values when setting the seniority attribute', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->seniority(['junior', 'senior', 'ignore', 'this too']);
    assertEquals(['junior', 'senior'], $domain_search->seniority);
});

it('sets the department attribute using a string', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->department('it');
    assertEquals(['it'], $domain_search->department);
});

it('sets the department attribute using an array', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->department(['it', 'management']);
    assertEquals(['it', 'management'], $domain_search->department);
});

it('ignores invalid values when setting the department attribute', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->department(['it', 'management', 'ignore', 'this too']);
    assertEquals(['it', 'management'], $domain_search->department);
});

it('can chain methods', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->domain('ghost.org')->company('Ghost')->limit(22)->offset(8);
    assertEquals('ghost.org', $domain_search->domain);
    assertEquals('Ghost', $domain_search->company);
    assertEquals(22, $domain_search->limit);
    assertEquals(8, $domain_search->offset);
});

it('builds the query with all fields set', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $query = $domain_search->domain('ghost.org')->department(['it', 'management'])->type('personal')
        ->seniority('junior')->limit(2)->offset(2)->make();
    assertEquals('https://api.hunter.io/v2/domain-search?domain=ghost.org&type=personal&department=it,management&seniority=junior&limit=2&offset=2&api_key=testing', $query);
});

it('builds the query with just the company name', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $query = $domain_search->company('Ghost')->make();
    assertEquals('https://api.hunter.io/v2/domain-search?company=Ghost&limit=10&api_key=testing', $query);
});

it('throws an InvalidRequestException when required fields are missing', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->make();
})->throws(InvalidRequestException::class, 'Either Domain or Company fields are required.');

it('makes the api call when required attributes are set', function () {
    $domain_search = new DomainSearch($_SERVER['HUNTER_API_KEY']);
    $domain_search->company('Ghost')->get();
})->skip('Do not make successful call to hunter with testing credentials');

it('mocks the ZTTP Request', function () {
    //
});

it('throws AuthorizationException when API key provided is invalid', function () {
    $domain_search = new DomainSearch('bad key');
    $domain_search->company('Ghost')->get();
})->throws(AuthorizationException::class);
