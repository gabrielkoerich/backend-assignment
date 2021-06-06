<?php

namespace App\Http\Controller\Api;

use App\Post\Model\JsonPlaceholderPostRepository;

class PostController
{
    /**
     * Create a new instance.
     */
    public function __construct(private JsonPlaceholderPostRepository $posts)
    {
        //
    }

    /**
     * List all resources.
     */
    public function index()
    {
        return $this->posts->all();
    }

    /**
     * Find a post.
     */
    public function find(int $id)
    {
        return $this->posts->find($id);
    }

    /**
     * Find all post comments posts
     */
    public function findComments(int $id)
    {
        return $this->posts->comments($id)->all();
    }
}
