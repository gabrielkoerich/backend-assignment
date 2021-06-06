<?php

namespace App\Http\Controller\Api;

use App\User\Model\JsonPlaceholderUserRepository;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserController
{
    use ValidatesRequests;

    /**
     * Create a new instance.
     */
    public function __construct(private JsonPlaceholderUserRepository $users)
    {
        //
    }

    /**
     * List all resources.
     */
    public function index()
    {
        return $this->users->all();
    }

    /**
     * Find a user.
     */
    public function find($id)
    {
        return $this->users->find($id);
    }
}
