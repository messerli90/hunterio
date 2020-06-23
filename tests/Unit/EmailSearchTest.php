<?php

namespace Messerli90\Hunterio\Tests;

use Mockery;
use Zttp\Zttp;
use PHPUnit\Framework\TestCase;
use Messerli90\Hunterio\EmailSearch;
use Messerli90\Hunterio\Exceptions\InvalidRequestException;

class EmailSearchTest extends TestCase
{
    /** @var \Zttp\Zttp|\Mockery\Mock */
    protected $http_client;

    /** @var \Messerli90\Hunterio\DomainSearch */
    protected $email_search;

    protected function setUp(): void
    {
        $this->http_client = Mockery::mock(Zttp::class);

        $this->email_search = new EmailSearch($this->http_client, 'apikey');
    }

    protected function tearDown(): void
    {
        Mockery::close();
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
}
