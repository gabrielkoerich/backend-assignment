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
}
