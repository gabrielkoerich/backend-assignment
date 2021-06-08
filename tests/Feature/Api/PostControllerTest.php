<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\User\Model\InternalUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test list all users
     */
    public function testGetAllPosts()
    {
        Sanctum::actingAs(InternalUser::factory()->create(), ['*']);

        // Cache users first bc of foreign keys
        $this->get('api/user');

        $response = $this->get('api/post');

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'sunt aut facere repellat provident occaecati excepturi optio reprehenderit']);

        // Run again, cache hit
        $response = $this->get('api/post');

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'sunt aut facere repellat provident occaecati excepturi optio reprehenderit']);
    }


    /**
     * Test find post
     */
    public function testFindPost()
    {
        Sanctum::actingAs(InternalUser::factory()->create(), ['*']);

        // Cache users first bc of foreign keys
        $this->get('api/user');

        $id = 7;

        $response = $this->get('api/post/' . $id);

        $response->assertStatus(200);

        $post = json_decode($response->getContent());

        $this->assertEquals($id, $post->id);
        $this->assertEquals('magnam facilis autem', $post->title);

        // Run again, cache hit
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
        Sanctum::actingAs(InternalUser::factory()->create(), ['*']);

        // Cache users first bc of foreign keys
        $this->get('api/user');
        $this->get('api/post');

        $id = 3;

        $response = $this->get("api/post/{$id}/comments");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'aut inventore non pariatur sit vitae voluptatem sapiente']);

        $response = $this->get("api/post/{$id}/comments");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'aut inventore non pariatur sit vitae voluptatem sapiente']);
    }
}
