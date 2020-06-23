<?php

namespace Messerli90\Hunterio;

use Illuminate\Http\Client\Response;
use Messerli90\Hunterio\Exceptions\AuthorizationException;
use Messerli90\Hunterio\Exceptions\InvalidRequestException;
use Messerli90\Hunterio\Exceptions\UsageException;

class Hunter
{
    /**
     * @var string api_key
     */
    protected $api_key;

    /** @var \Illuminate\Support\Facades\Http */
    // protected $client;

    /**
     * @param string|null $api_key
     * @return void
     * @throws AuthorizationException
     */
    public function __construct(string $api_key = null)
    {
        if (!$api_key) {
            throw new AuthorizationException('API key required');
        }
        $this->api_key = $api_key;
        // $this->client = $client;
    }

    /**
     *
     * @param mixed $attr
     * @return mixed
     */
    public function __get($attr)
    {
        return $this->$attr;
    }

    protected function handleErrors(Response $response)
    {
        $message = $response->json()['errors'][0]['details'];
        if ($response->status() === 401) {
            // No valid API key was provided.
            return new AuthorizationException($message);
        } else if (in_array($response->status(), [403, 429])) {
            // Thrown when `usage limit` or `rate limit` is reached
            // Upgrade your plan if necessary.
            return new UsageException($message);
        } else {
            // Your request was not valid.
            return new InvalidRequestException($message);
        }
    }
}
