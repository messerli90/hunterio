<?php

use Messerli90\Hunterio\HunterResponse;

beforeEach(function () {
    $this->mocked_response = json_decode(file_get_contents(__DIR__ . '/../mocks/domain-search.json'), true);
    $this->response = HunterResponse::createFromJson($this->mocked_response);
});

it('gets the data attribute', function () {
    assertEquals($this->mocked_response['data'], $this->response->getData());
});

it('gets the meta attribute', function () {
    assertEquals($this->mocked_response['meta'], $this->response->getMeta());
});

it('returns a collection of HunterEmail objects', function () {
    assertInstanceOf('Illuminate\Support\Collection', $this->response->getEmails());
    assertInstanceOf('Messerli90\Hunterio\HunterEmail', $this->response->getEmails()->first());
});
