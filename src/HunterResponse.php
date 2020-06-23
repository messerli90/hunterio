<?php

namespace Messerli90\Hunterio;

class HunterResponse
{
    /**
     * Full response body returned from Hunter.io
     *
     * @var array
     */
    public $response;

    /**
     * Data object
     *
     * @var array
     */
    public $data;

    /**
     * Meta data
     *
     * @var array
     */
    public $meta;

    public function __construct($json)
    {
        $this->response = $json;
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

    public function getResponse()
    {
        return $this->response;
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
        if (empty($this->data['emails'])) {
            return collect();
        }
        return collect(array_map(function ($email) {
            return new HunterEmail($email);
        }, $this->data['emails']));
    }
}
