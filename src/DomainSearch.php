<?php

namespace Messerli90\Hunterio;

use Messerli90\Hunterio\Exceptions\InvalidRequestException;

/**
 * This API endpoint searchers all the email addresses corresponding to one website.
 *
 * @package Messerli90\Hunterio
 */
class DomainSearch extends HunterClient
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
     * Specifies the max number of email addresses to return
     *
     * @var int
     */
    public $limit = 0;

    /**
     * Specifies the number of email addresses to skip
     *
     * @var int
     */
    public $offset = 0;

    /**
     * Specifies the type of email addresses to return
     *
     * @var string
     */
    public $type;

    /**
     * Specifies the selected seniority levels
     *
     * @var array
     */
    public $seniority = [];

    /**
     * Specifies the selected departments
     *
     * @var array
     */
    public $department = [];

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
     * Set max number of emails to return. Max 100
     *
     * @param int $limit
     * @return DomainSearch
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit <= 100 ? $limit : 10;

        return $this;
    }

    /**
     * Set the number of email addresses to skip
     *
     * @param int $offset
     * @return DomainSearch
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;

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
     * Set the selected seniority levels to include in search
     * The possible values are junior, senior or executive. Several seniority levels can be selected
     *
     * @param string|array $type
     * @return DomainSearch
     */
    public function seniority($seniority): self
    {
        $this->seniority = array_filter((array) $seniority, function ($val) {
            return in_array($val, ['junior', 'senior', 'executive']);
        });

        return $this;
    }

    /**
     * Set the selected departments to include in search
     * The possible values are executive, it, finance, management, sales, legal, support, hr, marketing or communication
     *
     * @param string|array $type
     * @return DomainSearch
     */
    public function department($department): self
    {
        $this->department = array_filter((array) $department, function ($val) {
            return in_array($val, [
                'executive', 'it', 'finance', 'management', 'sales', 'legal', 'support', 'hr', 'marketing', 'communication'
            ]);
        });

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

        $query = "{$this->base_url}/domain-search?";

        if ($this->company) {
            $query .= "company={$this->company}&";
        }
        if ($this->domain) {
            $query .= "domain={$this->domain}&";
        }
        if ($this->type) {
            $query .= "type={$this->type}&";
        }
        if ($this->department && count((array) $this->department)) {
            $query .= "department=" . implode(",", $this->department) . "&";
        }
        if ($this->seniority && count((array) $this->seniority)) {
            $query .= "seniority=" . implode(",", $this->seniority) . "&";
        }
        if ($this->limit) {
            $query .= "limit={$this->limit}&";
        }
        if ($this->offset) {
            $query .= "offset={$this->offset}&";
        }

        $query .= "api_key={$this->api_key}";

        return $query;
    }
}
