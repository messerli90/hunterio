<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Unit;

use Bisnow\Hunterio\DomainSearch;
use Bisnow\Hunterio\Exceptions\InvalidRequestException;
use Bisnow\Hunterio\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class DomainSearchTest extends TestCase
{
    /** @var \Bisnow\Hunterio\DomainSearch */
    protected $domain_search;

    protected function setUp(): void
    {
        parent::setUp();

        $this->domain_search = new DomainSearch('apikey');
    }

    public function test_it_gets_instantiated_with_an__ap_i_key(): void
    {
        $this->assertSame('apikey', $this->domain_search->__get('api_key'));
    }

    public function test_it_sets_attributes(): void
    {
        $this->domain_search->domain('ghost.org');
        $this->assertSame('ghost.org', $this->domain_search->domain);

        $this->domain_search->company('Ghost');
        $this->assertSame('Ghost', $this->domain_search->company);

        $this->domain_search->limit(20);
        $this->assertSame(20, $this->domain_search->limit);

        $this->domain_search->offset(15);
        $this->assertSame(15, $this->domain_search->offset);

        $this->domain_search->type('personal');
        $this->assertSame('personal', $this->domain_search->type);

        $this->domain_search->seniority('junior');
        $this->assertSame(['junior'], $this->domain_search->seniority);

        $this->domain_search->seniority(['junior', 'senior']);
        $this->assertSame(['junior', 'senior'], $this->domain_search->seniority);

        $this->domain_search->seniority(['junior', 'senior', 'ignore', 'this too']);
        $this->assertSame(['junior', 'senior'], $this->domain_search->seniority);

        $this->domain_search->department('it');
        $this->assertSame(['it'], $this->domain_search->department);

        $this->domain_search->department(['it', 'management']);
        $this->assertSame(['it', 'management'], $this->domain_search->department);

        $this->domain_search->department(['it', 'management', 'ignore', 'this too']);
        $this->assertSame(['it', 'management'], $this->domain_search->department);
    }

    public function test_it_sets_limit_attribute_to_10_if_number_provided_is_bigger_than_100(): void
    {
        $this->domain_search->limit(101);
        $this->assertSame(10, $this->domain_search->limit);
    }

    public function test_throws_an__invalid_request_exception_when_invalid_type_is_supplied(): void
    {
        $this->expectException(InvalidRequestException::class);

        $this->domain_search->type('bad type');
    }

    public function test_it_can_chain_methods(): void
    {
        $this->domain_search->domain('ghost.org')->company('Ghost')->limit(22)->offset(8);

        $this->assertSame('ghost.org', $this->domain_search->domain);
        $this->assertSame('Ghost', $this->domain_search->company);
        $this->assertSame(22, $this->domain_search->limit);
        $this->assertSame(8, $this->domain_search->offset);
    }

    public function test_it_builds_the_query(): void
    {
        $expected_query = [
            'company' => null,
            'domain' => 'ghost.org',
            'type' => 'personal',
            'department' => 'it,management',
            'seniority' => 'junior',
            'limit' => 2,
            'offset' => 2,
            'api_key' => 'apikey',
        ];

        $query = $this->domain_search->domain('ghost.org')->department(['it', 'management'])->type('personal')
            ->seniority('junior')->limit(2)->offset(2)->make();

        $this->assertSame($expected_query, $query);
    }

    public function test_it_throws_an__invalid_request_exception_when_required_fields_are_missing(): void
    {
        $this->expectException(InvalidRequestException::class);

        $this->domain_search->make();
    }

    public function test_it_returns_a_response_with_get(): void
    {
        $expected_response = file_get_contents(__DIR__.'/../mocks/domain-search.json');

        Http::fake(function ($request) use ($expected_response) {
            return Http::response($expected_response);
        });

        $response = $this->domain_search->domain('ghost.org')->get();

        $this->assertSame(json_decode($expected_response, true)['data']['domain'], $response['data']['domain']);
    }
}
