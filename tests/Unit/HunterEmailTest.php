<?php

use Messerli90\Hunterio\HunterEmail;

beforeEach(function () {
    $this->mocked_response = json_decode(file_get_contents(__DIR__ . '/../mocks/domain-search.json'), true);
    $this->email = new HunterEmail($this->mocked_response['data']['emails'][0]);
});

it('gets the value', function () {
    assertEquals('ciaran@intercom.io', $this->email->value);
});

it('gets the type', function () {
    assertEquals('personal', $this->email->type);
});

it('gets the confidence', function () {
    assertEquals(92, $this->email->confidence);
});

it('gets the sources', function () {
    assertEquals(collect($this->mocked_response['data']['emails'][0]['sources']), $this->email->sources);
});

it('gets the first_name', function () {
    assertEquals('Ciaran', $this->email->first_name);
});

it('gets the last_name', function () {
    assertEquals('Lee', $this->email->last_name);
});

it('gets the position', function () {
    assertEquals('Support Engineer', $this->email->position);
});

it('gets the seniority', function () {
    assertEquals('senior', $this->email->seniority);
});

it('gets the department', function () {
    assertEquals('it', $this->email->department);
});

it('gets the linkedin', function () {
    assertEquals(null, $this->email->linkedin);
});

it('gets the twitter', function () {
    assertEquals('ciaran_lee', $this->email->twitter);
});

it('gets the phone_number', function () {
    assertEquals(null, $this->email->phone_number);
});
