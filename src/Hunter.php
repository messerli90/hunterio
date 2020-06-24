<?php

namespace Messerli90\Hunterio;

use Illuminate\Support\Facades\Http;

class Hunter extends HunterClient
{
    public function account()
    {
        $this->endpoint = 'account';
        return $this->get();
    }

    public function domainSearch()
    {
        return new DomainSearch($this->api_key);
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
