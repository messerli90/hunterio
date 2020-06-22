<?php

namespace Messerli90\Hunterio;

class HunterResponse
{
    /**
     *
     * @var mixed
     */
    protected $json_object;

    /**
     * Data
     *
     * @var mixed
     */
    public $data;

    /**
     * Meta data
     *
     * @var mixed
     */
    public $meta;

    public function __construct($json)
    {
        $this->json_object = $json;
        $this->data = $json['data'];
        $this->meta = $json['meta'];
    }

    /**
     * Create a new HunterResponse from a JSON
     *
     * @param mixed $json
     * @return HunterResponse
     */
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
        return collect(array_map(function ($email) {
            return new HunterEmail($email);
        }, $this->data['emails']));
    }
}
