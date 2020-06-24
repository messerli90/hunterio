<?php

namespace Messerli90\Hunterio;

use Illuminate\Support\Facades\Http;

class Hunter extends HunterClient
{
    public function account()
    {
        $response = Http::get("https://api.hunter.io/v2/account?api_key={$this->api_key}");

        if ($response->ok()) {
            return $response->json();
        } else {
            return $this->handleErrors($response);
        }
    }
}
