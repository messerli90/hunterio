<?php

namespace Messerli90\Hunterio;

use Illuminate\Support\Facades\Http;
use Messerli90\Hunterio\Exceptions\InvalidRequestException;

class EmailCount extends Hunter
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
     * Set the type of email addresses to include in search
     * A "generic" email address is a role-based email address, like contact@hunter.io.
     * On the contrary, a "personal" email address is the address of someone in the company.
     *
     * @param string $type
     * @return DomainSearch
     */
    public function type(string $type): self
    {
        if (!in_array($type, ['generic', 'personal'])) {
            throw new InvalidRequestException('Type must be either "generic" or "personal".');
        }
        $this->type = $type;

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

    public function make()
    {
        if (empty($this->company) && empty($this->domain)) {
            throw new InvalidRequestException('Either Domain or Company fields are required.');
        }

        $query = 'https://api.hunter.io/v2/email-count?';

        if ($this->company) {
            $query .= "company={$this->company}&";
        }
        if ($this->domain) {
            $query .= "domain={$this->domain}&";
        }

        $query .= "api_key={$this->api_key}";

        return $query;
    }

    public function get()
    {
        $query = $this->make();

        $response = Http::get($query);

        if ($response->ok()) {
            return new HunterResponse($response->json(), 'count');
        } else {
            return $this->handleErrors($response);
        }
    }
}
