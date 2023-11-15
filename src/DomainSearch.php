<?php

declare(strict_types=1);

namespace Bisnow\Hunterio;

use Bisnow\Hunterio\Exceptions\InvalidRequestException;

/**
 * This API endpoint searchers all the email addresses corresponding to one website.
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

    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key);

        $this->endpoint = 'domain-search';
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
     * Set max number of emails to return. Max 100
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit <= 100 ? $limit : 10;

        return $this;
    }

    /**
     * Set the number of email addresses to skip
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
     */
    public function type(string $type): self
    {
        if (! in_array($type, ['generic', 'personal'])) {
            throw new InvalidRequestException('Type must be either "generic" or "personal".');
        }
        $this->type = $type;

        return $this;
    }

    /**
     * Set the selected seniority levels to include in search
     * The possible values are junior, senior or executive. Several seniority levels can be selected
     *
     * @param  string|array  $seniority
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
     * @param  string|array  $department
     */
    public function department($department): self
    {
        $this->department = array_filter((array) $department, function ($val) {
            return in_array($val, [
                'executive', 'it', 'finance', 'management', 'sales', 'legal', 'support', 'hr', 'marketing', 'communication',
            ]);
        });

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

        $this->query_params = [
            'company' => $this->company ?? null,
            'domain' => $this->domain ?? null,
            'type' => $this->type ?? null,
            'department' => count($this->department) ? implode(',', $this->department) : null,
            'seniority' => count($this->seniority) ? implode(',', $this->seniority) : null,
            'limit' => $this->limit ?? null,
            'offset' => $this->offset ?? null,
            'api_key' => $this->api_key ?? null,
        ];

        return $this->query_params;
    }
}
