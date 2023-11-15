<?php

declare(strict_types=1);

namespace Bisnow\Hunterio\Tests\Integration;

use Bisnow\Hunterio\Exceptions\AuthorizationException;
use Bisnow\Hunterio\Tests\TestCase;
use Hunter;

class HunterServiceProviderTest extends TestCase
{
    public function test_it_will_throw_an_exception_if_hunter_api_key_is_not_set(): void
    {
        $this->app['config']->set('services.hunter.key', '');

        $this->expectException(AuthorizationException::class);

        Hunter::account();
    }

    public function test_it_will_check_for_a_hunter_config_file(): void
    {
        $this->app['config']->set('hunter.key', 'hunter');
        $this->app['config']->set('services.hunter.key', 'services-hunter');

        $this->assertSame('hunter', Hunter::__get('api_key'));
    }

    public function test_it_checks_services_config_if_hunter_config_is_missing(): void
    {
        $this->app['config']->set('hunter.key', '');
        $this->app['config']->set('services.hunter.key', 'services-hunter');

        $this->assertSame('services-hunter', Hunter::__get('api_key'));
    }

    public function test_it_registers_the__hunter_facade(): void
    {
        $this->app['config']->set('services.hunter.key', 'apikey');

        $domain_search = $this->app['hunterio'];

        $this->assertInstanceOf(\Bisnow\Hunterio\Hunter::class, $domain_search);
    }
}
