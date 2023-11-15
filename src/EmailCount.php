<?php

declare(strict_types=1);

namespace Bisnow\Hunterio;

use Bisnow\Hunterio\Exceptions\InvalidRequestException;

class EmailCount extends HunterClient
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
     * Specifies the type of email addresses to return
     *
     * @var string
     */
    public $type;

    public function __construct()
    {
        $this->endpoint = 'email-count';
    }

    /**
     * Sets domain to search
     *
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
     * @return DomainSearch
     */
    public function company(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Set the type of email addresses to include in search
     * A "generic" email address is a role-based email address, like contact@hunter.io.
     * On the contrary, a "personal" email address is the address of someone in the company.
     *
     * @return DomainSearch
     */
    public function type(string $type): self
    {
        if (! in_array($type, ['generic', 'personal'])) {
            throw new InvalidRequestException('Type must be either "generic" or "personal".');
        }
        $this->type = $type;

        return $this;
    }

    public function make()
    {
        if (empty($this->company) && empty($this->domain)) {
            throw new InvalidRequestException('Either Domain or Company fields are required.');
        }

        $this->query_params = [
            'company' => $this->company ?? null,
            'domain' => $this->domain ?? null,
            'type' => $this->type ?? null,
        ];

        return $this->query_params;
    }
}
