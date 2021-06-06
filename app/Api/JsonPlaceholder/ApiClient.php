<?php

namespace App\Api\JsonPlaceholder;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class ApiClient
{
    /**
     * The Guzzle http client.
     */
    private Client $http;

    /**
     * The API host
     */
    private string $host = 'https://jsonplaceholder.typicode.com';

    /**
     * The related resource
     */
    private array $relation = [];

    /**
     * Create a new instance.
     */
    public function __construct(Client $http = null)
    {
        $this->http = $http;
    }

    /**
     * Get or set the Http Client.
     */
    public function getHttpClient(): Client
    {
        return $this->http ?: new Client;
    }

    /**
     * Specify the request should be loaded in a related resource
     */
    public function fromRelation(string $resource, int $id)
    {
        $this->relation = [$resource, $id];

        return $this;
    }

    /**
     * Get all of the specified resource.
     */
    public function all(string $resource, array $options = []): Collection
    {
        $response = $this->getHttpClient()
            ->get($this->getResourceUri($resource), $options);

        return $this->toCollection($response);
    }

    /**
     * Get a given resource.
     */
    public function find(string $resource, int $id, array $options = []): array
    {
        $response = $this->getHttpClient()
            ->get($this->getResourceUri($resource, $id), $options);

        return $this->getContentFromResponse($response);
    }

    /**
     * Get the resource endpoint.
     */
    private function getResourceUri(string $resource, int $id = null): string
    {
        if (count($this->relation)) {
            [$relatedResource, $relatedId] = $this->relation;

            return vsprintf('%s/%s/%s/%s', [
                $this->host,
                $relatedResource,
                $relatedId,
                $resource
            ]);
        }

        return vsprintf('%s/%s/%s', [
            $this->host,
            $resource,
            $id,
        ]);
    }

    /**
     * Transform a response into a collection.
     */
    protected function toCollection(ResponseInterface $response): Collection
    {
        return new Collection($this->getContentFromResponse($response));
    }

    /**
     * Get the response content.
     */
    protected function getContentFromResponse(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
