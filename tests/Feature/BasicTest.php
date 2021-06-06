<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User\Model\InternalUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BasicTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testHome()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $user = InternalUser::factory()->make();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }
}
