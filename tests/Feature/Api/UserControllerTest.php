<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test list all users
     *
     * @group now
     */
    public function testGetAllUsers()
    {
        $response = $this->get('api/user');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Leanne Graham'])
            ->assertJsonFragment(['username' => 'Kamren'])
            ->assertJsonFragment(['email' => 'Rey.Padberg@karina.biz']);

        // Call it again, it will be cached on the database:
        $response = $this->get('api/user');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Leanne Graham'])
            ->assertJsonFragment(['username' => 'Kamren'])
            ->assertJsonFragment(['email' => 'Rey.Padberg@karina.biz']);
    }


    /**
     * Test list all users
     */
    public function testFindUser()
    {
        $id = 7;

        $response = $this->get('api/user/' . $id);

        $response->assertStatus(200);

        $user = json_decode($response->getContent());

        $this->assertEquals($id, $user->id);
        $this->assertEquals('Kurtis Weissnat', $user->name);
        $this->assertEquals('Telly.Hoeger@billy.biz', $user->email);
    }

    /**
     * Test list all user posts
     */
    public function testListUserPosts()
    {
        $id = 3;

        $response = $this->get("api/user/{$id}/posts");

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'asperiores ea ipsam voluptatibus modi minima quia sint']);
    }
}
