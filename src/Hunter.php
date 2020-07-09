<?php

namespace Messerli90\Hunterio;

class Hunter extends HunterClient
{
    public function account()
    {
        $this->endpoint = 'account';
        $this->query_params = [
            'api_key' => $this->api_key ?? null
        ];
        return $this->get();
    }

    public function domainSearch($domain = null)
    {
        if (!$domain) {
            return new DomainSearch($this->api_key);
        }
        return (new DomainSearch($this->api_key))->domain($domain)->get();
    }

    public function emailCount()
    {
        return new EmailCount($this->api_key);
    }

    public function emailFinder()
    {
        return new EmailFinder($this->api_key);
    }

    public function emailVerifier()
    {
        return new EmailVerifier($this->api_key);
    }
}
