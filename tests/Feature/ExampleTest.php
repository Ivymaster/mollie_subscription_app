<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');
        //$response->assertSee("Laravel");
        $response->assertStatus(200);
    }

    public function test_register_route_is_valid()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_home_route_is_auth_protected()
    {
        $response = $this->get('/home');
        $response->assertStatus(302);
    }
}
