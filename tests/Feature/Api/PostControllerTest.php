<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test list all users
     */
    public function testGetAllPosts()
    {
        $response = $this->get('api/post');

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'sunt aut facere repellat provident occaecati excepturi optio reprehenderit']);
    }


    /**
     * Test find post
     */
    public function testFindPost()
    {
        $id = 7;

        $response = $this->get('api/post/' . $id);

        $response->assertStatus(200);

        $post = json_decode($response->getContent());

        $this->assertEquals($id, $post->id);
        $this->assertEquals('magnam facilis autem', $post->title);
    }

    /**
     * Test list all post comments
     */
    public function testListPostComments()
    {
        $id = 3;

        $response = $this->get("api/post/{$id}/comments");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'aut inventore non pariatur sit vitae voluptatem sapiente']);
    }
}
