<?php

namespace App\User\Model;

use Illuminate\Support\Collection;
use App\Api\JsonPlaceholder\ApiClient;
use App\Api\JsonPlaceholder\ApiRepository;

class JsonPlaceholderUserRepository extends ApiRepository
{
    /**
     * The resource
     */
    protected string $resource = 'users';
}
