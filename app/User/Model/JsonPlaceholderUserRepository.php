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
     * The cache model.
     */
    // protected ?string $cacheModel = User::class;

    /**
     * The cache minutes.
     */
    protected int $cacheMinutes = 5;

    /**
     * Define posts relation
     */
    public function posts(int $userId): JsonPlaceholderPostRepository
    {
        return (new JsonPlaceholderPostRepository($this->client))
            ->related($userId);
    }
}
