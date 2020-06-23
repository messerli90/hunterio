<?php

namespace Messerli90\Hunterio\Tests;

use PHPUnit\Framework\TestCase;
use Messerli90\Hunterio\HunterResponse;

class HunterResponseTest extends TestCase
{
    /** @var array */
    protected $response_json;

    /** @var \Messerli90\Hunterio\HunterResponse */
    protected $hunter_response;

    protected function setUp(): void
    {
        $this->response_json = json_decode(file_get_contents(__DIR__ . '/../mocks/domain-search.json'), true);
        $this->hunter_response = new HunterResponse($this->response_json);
    }

    /** @test */
    public function it_gets_the_data_attribute()
    {
        $this->assertEquals($this->response_json['data'], $this->hunter_response->getData());
    }

    /** @test */
    public function it_gets_the_meta_attribute()
    {
        $this->assertEquals($this->response_json['meta'], $this->hunter_response->getMeta());
    }

    /** @test */
    public function it_returns_a_collection_of_HunterEmail_objects()
    {
        $this->assertInstanceOf('Illuminate\Support\Collection', $this->hunter_response->getEmails());
        $this->assertInstanceOf('Messerli90\Hunterio\HunterEmail', $this->hunter_response->getEmails()->first());
    }
}
