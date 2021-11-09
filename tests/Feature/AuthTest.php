<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    public function setUp(): void
    {
        parent::setUp();
        (new DatabaseSeeder)->call(RoleSeeder::class);
        $this->user =  User::factory()->create([
            "email" => "ivan@gmail.com",
            "password" => bcrypt("IvanIvusic")
        ]);
        $this->user->attachRole("admin");
    }
    public function test_login_redirects_successfully()
    {
        $response = $this->post("login", ["email" => $this->user->email, "password" => "IvanIvusic"]);
        $response->assertStatus(302);
        $response->assertRedirect("/home");
    }

    public function test_authenticated_admin_user_can_acces_home_page(){
        $response = $this->actingAs($this->user)->get("/home");
        $response->assertStatus(200);
    }

    public function test_unauthenticated_user_can_not_acces_home_page(){
        $response = $this->get("/home");
        $response->assertStatus(302);
    }
}
