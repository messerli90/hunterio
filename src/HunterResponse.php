<?php

namespace Messerli90\Hunterio;

class HunterResponse
{
    public $json_object;
    public $data;
    public $meta;

    public function __construct($json)
    {
        $this->json_object = $json;
        $this->data = $json['data'];
        $this->meta = $json['meta'];
    }

    public static function createFromJson($json): self
    {
        return new self($json);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function getEmails()
    {
        return collect($this->data['emails']);
    }
}
