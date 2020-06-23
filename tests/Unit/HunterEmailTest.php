<?php

namespace Messerli90\Hunterio\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Messerli90\Hunterio\HunterEmail;

class HunterEmailTest extends TestCase
{
    /** @var array */
    protected $response_json;

    /** @var \Messerli90\Hunterio\HunterEmail */
    protected $email;

    protected function setUp(): void
    {
        $this->response_json = json_decode(file_get_contents(__DIR__ . '/../mocks/domain-search.json'), true);
        $this->email = new HunterEmail($this->response_json['data']['emails'][0]);
    }

    /** @test */
    public function it_returns_attributes()
    {
        $this->assertEquals('ciaran@intercom.io', $this->email->value);
        $this->assertEquals('personal', $this->email->type);
        $this->assertEquals(92, $this->email->confidence);
        $this->assertEquals(collect($this->response_json['data']['emails'][0]['sources']), $this->email->sources);
        $this->assertEquals('Ciaran', $this->email->first_name);
        $this->assertEquals('Lee', $this->email->last_name);
        $this->assertEquals('Support Engineer', $this->email->position);
        $this->assertEquals('senior', $this->email->seniority);
        $this->assertEquals('it', $this->email->department);
        $this->assertEquals(null, $this->email->linkedin);
        $this->assertEquals('ciaran_lee', $this->email->twitter);
        $this->assertEquals(null, $this->email->phone_number);
    }
}
