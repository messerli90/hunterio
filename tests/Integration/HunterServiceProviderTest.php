<?php

namespace Messerli90\Hunterio\Tests\Integration;

use DomainSearch;
use EmailSearch;
use Messerli90\Hunterio\Exceptions\AuthorizationException;

class HunterServiceProviderTest extends TestCase
{
    /** @test */
    public function it_will_throw_an_exception_if_hunter_api_key_is_not_set()
    {
        $this->app['config']->set('services.hunter.key', '');

        $this->expectException(AuthorizationException::class);

        DomainSearch::domain('ghost.org')->get();
    }

    /** @test */
    public function it_registers_the_DomainSearch_facade()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        $domain_search = $this->app['hunter-domain-search'];

        $this->assertInstanceOf(\Messerli90\Hunterio\DomainSearch::class, $domain_search);
    }

    /** @test */
    public function it_registers_the_EmailSearch_facade()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        $email_search = $this->app['hunter-email-search'];

        $this->assertInstanceOf(\Messerli90\Hunterio\EmailSearch::class, $email_search);
    }
}
