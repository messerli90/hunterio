<?php

namespace Messerli90\Hunterio\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Messerli90\Hunterio\EmailFinder;
use Messerli90\Hunterio\Exceptions\InvalidRequestException;
use Messerli90\Hunterio\Tests\TestCase;

class EmailFinderTest extends TestCase
{
    /** @var \Messerli90\Hunterio\EmailFinder */
    protected $email_search;

    public function setUp(): void
    {
        parent::setUp();

        $this->email_search = new EmailFinder('apikey');
    }

    /** @test */
    public function it_gets_instantiated_with_an_API_key()
    {
        $this->assertEquals('apikey', $this->email_search->__get('api_key'));
    }

    /** @test */
    public function it_sets_domain_and_company_attributes()
    {
        $this->email_search->domain('ghost.org');
        $this->assertEquals('ghost.org', $this->email_search->domain);

        $this->email_search->company('Ghost');
        $this->assertEquals('Ghost', $this->email_search->company);
    }

    /** @test */
    public function it_sets_the_name_attribute()
    {
        $this->email_search->name('Dustin Moskovitz');
        $this->assertEquals('Dustin+Moskovitz', $this->email_search->full_name);
        $this->assertEquals(null, $this->email_search->first_name);
        $this->assertEquals(null, $this->email_search->last_name);

        $this->email_search->name('Dustin', 'Moskovitz');
        $this->assertEquals(null, $this->email_search->full_name);
        $this->assertEquals('Dustin', $this->email_search->first_name);
        $this->assertEquals('Moskovitz', $this->email_search->last_name);

        $this->email_search->name('Dustin', 'Moskovitz')->name('Dustin Moskovitz');
        $this->assertEquals('Dustin+Moskovitz', $this->email_search->full_name);
        $this->assertEquals(null, $this->email_search->first_name);
        $this->assertEquals(null, $this->email_search->last_name);
    }

    /** @test */
    public function it_builds_the_query()
    {
        $expected_query = 'https://api.hunter.io/v2/email-finder?domain=ghost.org&first_name=Dustin&last_name=Moskovitz&api_key=apikey';

        $query = $this->email_search->domain('ghost.org')->name('Dustin', 'Moskovitz')->make();

        $this->assertEquals($expected_query, $query);
    }

    /** @test */
    public function it_throws_an_InvalidRequestException_when_company_or_domain_fields_are_missing()
    {
        $this->expectException(InvalidRequestException::class);

        $this->email_search->name('Dustin Moskovitz')->make();
    }

    /** @test */
    public function it_throws_an_InvalidRequestException_when_name_fields_are_missing()
    {
        $this->expectException(InvalidRequestException::class);

        $this->email_search->domain('ghost.org')->make();
    }

    /** @test */
    public function it_returns_a_json_response()
    {
        $expected_response = file_get_contents(__DIR__ . '/../mocks/email-finder.json');

        Http::fake(function ($request) use ($expected_response) {
            return Http::response($expected_response);
        });

        $response = $this->email_search->domain('ghost.org')->name('Dustin')->get();

        $this->assertEquals(json_decode($expected_response, true)['data']['email'], $response['data']['email']);
    }
}
