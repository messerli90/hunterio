<?php

namespace Messerli90\Hunterio;

use Illuminate\Support\Facades\Http;
use Messerli90\Hunterio\Exceptions\AuthorizationException;
use Messerli90\Hunterio\Exceptions\InvalidRequestException;
use Messerli90\Hunterio\Exceptions\UsageException;
use Messerli90\Hunterio\Interfaces\EndpointInterface;

class EmailVerifier extends HunterClient
{
    /**
     * The email address you want to verify.
     *
     * @var string
     */
    public $email;

    public function __construct(string $api_key = null)
    {
        parent::__construct($api_key);

        $this->endpoint = 'email-verifier';
    }

    /**
     * Sets email to search
     *
     * @param string $email
     * @return EmailVerifier
     */
    public function email(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Shortcut to set email and make request
     *
     * @param string $email
     * @return mixed
     * @throws InvalidRequestException
     * @throws AuthorizationException
     * @throws UsageException
     */
    public function verify(string $email)
    {
        $this->email($email)->make();
        return $this->get();
    }

    public function make()
    {
        if (empty($this->email)) {
            throw new InvalidRequestException('Email is required.');
        }

        $this->query_params = [
            'email' => $this->email ?? null,
            'api_key' => $this->api_key ?? null
        ];

        return $this->query_params;
    }
}
