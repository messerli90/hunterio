<?php

namespace Messerli90\Hunterio;

class HunterEmail
{
    /**
     * Email address value
     *
     * @var string
     */
    public $value;

    /**
     * Email address type
     *
     * @var string
     */
    public $type;

    /**
     * Confidence level
     *
     * @var int
     */
    public $confidence;

    /**
     * Sources where email address was found
     *
     * @var array
     */
    public $sources = [];

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $position;

    /**
     * @var string
     */
    public $seniority;

    /**
     * @var string
     */
    public $department;

    /**
     * @var string
     */
    public $linkedin;

    /**
     * @var string
     */
    public $twitter;

    /**
     * @var string
     */
    public $phone_number;

    public function __construct($json)
    {
        $this->value = $json['value'];
        $this->type = $json['type'];
        $this->confidence = $json['confidence'];
        $this->sources = collect($json['sources']);
        $this->first_name = $json['first_name'];
        $this->last_name = $json['last_name'];
        $this->position = $json['position'];
        $this->seniority = $json['seniority'];
        $this->department = $json['department'];
        $this->linkedin = $json['linkedin'];
        $this->twitter = $json['twitter'];
        $this->phone_number = $json['phone_number'];
    }
}
