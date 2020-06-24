<?php

namespace Messerli90\Hunterio;

use Illuminate\Support\Facades\Http;
use Messerli90\Hunterio\Exceptions\AuthorizationException;
use Messerli90\Hunterio\Exceptions\InvalidRequestException;
use Messerli90\Hunterio\Exceptions\UsageException;

class EmailVerifier extends Hunter
{
    /**
     * The email address you want to verify.
     *
     * @var string
     */
    public $email;

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
        return $this->email($email)->get();
    }

    public function make()
    {
        if (empty($this->email)) {
            throw new InvalidRequestException('Email is required.');
        }

        $query = 'https://api.hunter.io/v2/email-verifier?';
        $query .= "email={$this->email}&";
        $query .= "api_key={$this->api_key}";

        return $query;
    }

    public function get()
    {
        $query = $this->make();

        $response = Http::get($query);

        if ($response->ok()) {
            return $response->json();
        } else {
            return $this->handleErrors($response);
        }
    }
}
