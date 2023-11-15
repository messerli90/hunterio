<?php

declare(strict_types=1);

namespace Bisnow\Hunterio;

use Bisnow\Hunterio\Exceptions\AuthorizationException;
use Bisnow\Hunterio\Exceptions\InvalidRequestException;
use Bisnow\Hunterio\Exceptions\UsageException;
use Bisnow\Hunterio\Interfaces\EndpointInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class HunterClient implements EndpointInterface
{
    /** @var string */
    protected $api_key;

    /** @var string */
    protected $base_url = 'https://api.hunter.io/v2';

    /** @var string */
    public $endpoint = '';

    /** @var array */
    public $query_params = [];

    /**
     * @throws AuthorizationException
     */
    public function __construct(string $api_key = null)
    {
        if (empty($api_key)) {
            throw new AuthorizationException('API key required');
        }
        $this->api_key = $api_key;
    }

    /**
     * @param  mixed  $attr
     * @return mixed
     */
    public function __get($attr)
    {
        return $this->$attr;
    }

    public function make()
    {
        return array_filter($this->query_params, function ($q) {
            return isset($q);
        });
    }

    protected function buildUrl()
    {
        return "{$this->base_url}/{$this->endpoint}";
    }

    public function get()
    {
        $response = Http::get($this->buildUrl(), $this->make());

        if ($response->ok()) {
            return $response->json();
        } else {
            return $this->handleErrors($response);
        }
    }

    protected function handleErrors(Response $response): void
    {
        $message = $response->json()['errors'][0]['details'];
        if ($response->status() === 401) {
            // No valid API key was provided.
            throw new AuthorizationException($message);
        } elseif (in_array($response->status(), [403, 429])) {
            // Thrown when `usage limit` or `rate limit` is reached
            // Upgrade your plan if necessary.
            throw new UsageException($message);
        } else {
            // Your request was not valid.
            throw new InvalidRequestException($message);
        }
    }
}
