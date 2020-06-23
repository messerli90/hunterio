<?php

namespace Messerli90\Hunterio;

use Messerli90\Hunterio\Exceptions\AuthorizationException;
use Messerli90\Hunterio\Exceptions\InvalidRequestException;
use Messerli90\Hunterio\Exceptions\UsageException;
use Zttp\Zttp;

/**
 * This API endpoint generates or retrieves the most likely email address from a domain name, a first name and a last name.
 *
 * @package Messerli90\Hunterio
 */
class EmailSearch extends Hunter
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

    /**
     * Sets domain to search
     *
     * @param string $domain
     * @return DomainSearch
     */
    public function domain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Set company name to search
     *
     * @param string $company
     * @return DomainSearch
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
     *
     * @param string $first_name
     * @param string|null $last_name
     * @return EmailSearch
     */
    public function name(string $first_name, string $last_name = null): self
    {
        if ($last_name === null) {
            $this->full_name = implode("+", explode(" ", $first_name));
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

        $query = 'https://api.hunter.io/v2/email-finder?';

        if ($this->company) {
            $query .= "company={$this->company}&";
        }
        if ($this->domain) {
            $query .= "domain={$this->domain}&";
        }
        if ($this->full_name) {
            $query .= "full_name={$this->full_name}&";
        } else {
            $query .= "first_name={$this->first_name}&last_name={$this->last_name}&";
        }

        $query .= "api_key={$this->api_key}";

        return $query;
    }

    /**
     *
     * @param Zttp|null $client
     * @return HunterResponse
     * @throws InvalidRequestException
     * @throws AuthorizationException
     * @throws UsageException
     */
    public function get()
    {
        //
    }
}
