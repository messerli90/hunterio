<?php

namespace Tests;

use GuzzleHttp\Psr7\Response;
use Zttp\Zttp;
use Zttp\ZttpResponse;

function mockSuccessfulDomainSearchRequest()
{
    return \Mockery::mock(Zttp::class, function ($mock) {
        $mock->shouldReceive('get')->once()
            ->andReturn(
                new ZttpResponse(
                    new Response(
                        200,
                        [],
                        file_get_contents(__DIR__ . '/mocks/domain-search.json')
                    )
                )
            );
    });
}

function mockErrorDomainSearchRequest($error_status = 400)
{
    return \Mockery::mock(Zttp::class, function ($mock) use ($error_status) {
        $mock->shouldReceive('get')->once()
            ->andReturn(
                new ZttpResponse(
                    new Response(
                        $error_status,
                        [],
                        file_get_contents(__DIR__ . '/mocks/domain-search-error.json')
                    )
                )
            );
    });
}
