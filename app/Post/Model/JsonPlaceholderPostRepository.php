<?php

namespace App\Post\Model;

use Illuminate\Support\Collection;
use App\Api\JsonPlaceholder\ApiClient;
use App\Api\JsonPlaceholder\ApiRepository;

class JsonPlaceholderPostRepository extends ApiRepository
{
    /**
     * The resource
     */
    protected string $resource = 'posts';

    /**
     * Define comments relation
     */
    public function comments(int $postId): JsonPlaceholderCommentRepository
    {
        return (new JsonPlaceholderCommentRepository($this->client))
            ->related($postId);
    }
}
