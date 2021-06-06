<?php

namespace App\Api\JsonPlaceholder;

use Illuminate\Support\Collection;

abstract class ApiRepository
{
    /**
     * The Api client
     */
    protected ApiClient $client;

    /**
     * The resource
     */
    protected string $resource;

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

    /**
     * Find a resource by id.
     */
    public function find(int $id)
    {
        return $this->client->find($this->resource, $id);
    }

    /**
     * Set the related resource.
     */
    public function related(int $id)
    {
        $this->client->fromRelation($this->resource, $id);

        return $this;
    }
}
