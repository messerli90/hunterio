<?php

declare(strict_types=1);

namespace Bisnow\Hunterio;

use Bisnow\Hunterio\Exceptions\InvalidRequestException;

class EmailFinder extends HunterClient
{
    /**
     * Domain name from which you want to find the email addresses
     *
     * @var string
     */
    public $domain;

    /**
     * The company name from which you want to find the email addresses
     *
     * @var string
     */
    public $company;

    /**
     * The person's full name
     *
     * @var string
     */
    public $full_name;

    /**
     * The person's first name
     *
     * @var string
     */
    public $first_name;

    /**
     * The person's last name
     *
     * @var string
     */
    public $last_name;

    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key);

        $this->endpoint = 'email-finder';
    }

    /**
     * Sets domain to search
     */
    public function domain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Set company name to search
     */
    public function company(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Set the person's name to search
     * Sets `full_name` by passing in a single argument, or
     * sets `first_name` and `last_name` when passing two arguments
     *
     * Note that you'll get better results by supplying the person's first and last name if you can.
     */
    public function name(string $first_name, string $last_name = null): self
    {
        if ($last_name === null) {
            $this->full_name = implode('+', explode(' ', $first_name));
            $this->first_name = null;
            $this->last_name = null;
        } else {
            $this->full_name = null;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
        }

        return $this;
    }

    /**
     * Build query with set attributes
     *
     * @return string
     *
     * @throws InvalidRequestException
     */
    public function make()
    {
        if (empty($this->company) && empty($this->domain)) {
            throw new InvalidRequestException('Either Domain or Company fields are required.');
        }
        if (empty($this->full_name) && (empty($this->first_name) || empty($this->last_name))) {
            throw new InvalidRequestException('Either full name or first and last name fields are required.');
        }

        $this->query_params = [
            'company' => $this->company ?? null,
            'domain' => $this->domain ?? null,
            'api_key' => $this->api_key ?? null,
        ];

        if ($this->full_name) {
            $this->query_params = array_merge($this->query_params, ['full_name' => $this->full_name]);
        } else {
            $this->query_params = array_merge($this->query_params, [
                'first_name' => $this->first_name, 'last_name' => $this->last_name,
            ]);
        }

        return $this->query_params;
    }
}
