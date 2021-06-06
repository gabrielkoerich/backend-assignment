<?php

namespace Tests\Feature;

use App\User\Model\InternalUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $user = InternalUser::factory()->make();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
    }
}
