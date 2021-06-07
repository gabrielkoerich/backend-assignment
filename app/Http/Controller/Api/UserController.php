<?php

namespace App\Http\Controller\Api;

use Illuminate\Http\Response;
use App\User\Model\JsonPlaceholderUserRepository;

class UserController
{
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
    public function index(): Response
    {
        $users = $this->users->all();

        return new Response($users, 200);
    }

    /**
     * Find a user.
     */
    public function find(int $id): Response
    {
        $user = $this->users->find($id);

        return new Response($user, 200);
    }

    /**
     * Find all user posts
     */
    public function findPosts(int $id): Response
    {
        $posts = $this->users->posts($id)->all();

        return new Response($posts, 200);
    }
}
