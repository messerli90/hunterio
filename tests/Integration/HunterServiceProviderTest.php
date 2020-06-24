<?php

namespace Messerli90\Hunterio\Tests\Integration;

use Hunter;
use Messerli90\Hunterio\Exceptions\AuthorizationException;
use Messerli90\Hunterio\Tests\TestCase;

class HunterServiceProviderTest extends TestCase
{
    /** @test */
    public function it_will_throw_an_exception_if_hunter_api_key_is_not_set()
    {
        $this->app['config']->set('services.hunter.key', '');

        $this->expectException(AuthorizationException::class);

        Hunter::account();
    }

    /** @test */
    public function it_will_check_for_a_hunter_config_file()
    {
        $this->app['config']->set('hunter.key', 'hunter');
        $this->app['config']->set('services.hunter.key', 'services-hunter');

        $this->assertEquals('hunter', Hunter::__get('api_key'));
    }

    /** @test */
    public function it_checks_services_config_if_hunter_config_is_missing()
    {
        $this->app['config']->set('hunter.key', '');
        $this->app['config']->set('services.hunter.key', 'services-hunter');

        $this->assertEquals('services-hunter', Hunter::__get('api_key'));
    }


    /** @test */
    public function it_registers_the_Hunter_facade()
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        $domain_search = $this->app['hunterio'];

        $this->assertInstanceOf(\Messerli90\Hunterio\Hunter::class, $domain_search);
    }
}
