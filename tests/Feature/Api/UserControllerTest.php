<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test list all users
     */
    public function testGetAllUsers()
    {
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
}
