<?php

namespace App\Http\Controller\Api;

use Illuminate\Http\Response;
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
    public function index(): Response
    {
        $posts = $this->posts->all();

        // Should be returned with more data if we had pagination
        return new Response($posts, 200);
    }

    /**
     * Find a post.
     */
    public function find(int $id): Response
    {
        $post = $this->posts->find($id);

        return new Response($post, 200);
    }

    /**
     * Find all post comments posts
     */
    public function findComments(int $id): Response
    {
        $comments = $this->posts->comments($id)->all();

        return new Response($comments, 200);
    }
}
