<?php

namespace App\User\Model;

use Illuminate\Support\Collection;
use App\Api\JsonPlaceholder\ApiClient;

class JsonPlaceholderUserRepository
{
    /**
     * The resource
     */
    private string $resource = 'users';

    /**
     * Create a new instance.
     */
    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get all resources
     */
    public function all(): Collection
    {
        return $this->client->all($this->resource);
    }
}
