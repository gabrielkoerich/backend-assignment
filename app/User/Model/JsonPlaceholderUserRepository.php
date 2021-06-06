<?php

namespace App\User\Model;

use Illuminate\Support\Collection;
use App\Api\JsonPlaceholder\ApiClient;
use App\Api\JsonPlaceholder\ApiRepository;
use App\Post\Model\JsonPlaceholderPostRepository;

class JsonPlaceholderUserRepository extends ApiRepository
{
    /**
     * The resource
     */
    protected string $resource = 'users';

    /**
     * Define posts relation
     */
    public function posts(int $userId): JsonPlaceholderPostRepository
    {
        return (new JsonPlaceholderPostRepository($this->client))
            ->fromRelation($this->resource, $userId);
    }
}
