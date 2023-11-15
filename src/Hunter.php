<?php

declare(strict_types=1);

namespace Bisnow\Hunterio;

class Hunter extends HunterClient
{
    public function account()
    {
        $this->endpoint = 'account';
        $this->query_params = [
            'api_key' => $this->api_key ?? null,
        ];

        return $this->get();
    }

    public function domainSearch($domain = null)
    {
        if (! $domain) {
            return new DomainSearch($this->api_key);
        }

        return (new DomainSearch($this->api_key))->domain($domain)->get();
    }

    public function emailCount($domain = null)
    {
        if (! $domain) {
            return new EmailCount($this->api_key);
        }

        return (new EmailCount($this->api_key))->domain($domain)->get();
    }

    public function emailFinder($domain = null)
    {
        if (! $domain) {
            return new EmailFinder($this->api_key);
        }

        return (new EmailFinder($this->api_key))->domain($domain);
    }

    /**
     * @deprecated v1.1.0
     */
    public function emailVerifier()
    {
        return new EmailVerifier($this->api_key);
    }

    public function verifyEmail($email)
    {
        return (new EmailVerifier($this->api_key))->verify($email);
    }
}
