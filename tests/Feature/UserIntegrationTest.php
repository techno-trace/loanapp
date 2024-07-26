<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserIntegrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     *
     * @return void
     */
    public function test_it_contains_a_valid_name()
    {
        $response = $this->post('/api/register', [
            "email" => $this->faker()->email(),
            "password" => "password"
        ]);

        $response->assertStatus(200)->assertJsonValidationErrorFor('name');

        $response = $this->post('/api/register', [
            "name" => '',
            "email" => $this->faker()->email(),
            "password" => "password"
        ]);

        $response->assertStatus(200)->assertJsonValidationErrorFor('name');
    }


    /**
     *
     * @return void
     */
    public function test_it_contains_a_valid_email()
    {
        $response = $this->post('/api/register', [
            "name" => $this->faker()->name(),
            "password" => "password"
        ]);

        $response->assertStatus(200)->assertJsonValidationErrorFor('email');

        $response = $this->post('/api/register', [
            "name" => $this->faker()->name(),
            'email' => 'email',
            "password" => "password"
        ]);

        $response->assertStatus(200)->assertJsonValidationErrorFor('email');
    }

    /**
     *
     * @return void
     */
    public function test_it_contains_a_unique_email()
    {
        $email = $this->faker()->email();

        User::factory()->create(['email' => $email]);

        $response = $this->post('/api/register', [
            "name" => $this->faker()->name(),
            "email" => $email,
            "password" => "password"
        ]);

        $response->assertStatus(200)->assertJsonValidationErrorFor('email');
    }

    /**
     *
     * @return void
     */
    public function test_it_contains_a_valid_password()
    {
        $response = $this->post('/api/register', [
            "name" => $this->faker()->name(),
            "email" => $this->faker()->email(),
            "password" => "passwor"
        ]);

        $response->assertStatus(200)->assertJsonValidationErrorFor('password');
    }


    /**
     *
     * @return void
     */
    public function test_it_can_register_a_user()
    {
        $response = $this->post('/api/register', [
            "name" => $this->faker()->name(),
            "email" => $this->faker()->email(),
            "password" => "password"
        ]);

        $response->assertStatus(200)

        ->assertJsonStructure([
            "status",
            "message",
            "data" => [
                "name",
                "email",
                "updated_at" ,
                "created_at",
                "id",
            ],
            "access_token",
            "token_type"
        ]);

        $this->assertDatabaseCount('users', 1);
    }

    public function test_it_can_sign_in_a_user()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            "email" => $user->email,
            "password" => "password"
        ]);

        $response->assertStatus(200)

        ->assertJsonStructure([
            "status",
            "message",
            "data" => [
                "id",
                "name",
                "email",
                "email_verified_at",
                "updated_at" ,
                "created_at",
            ],
            "access_token",
            "token_type"
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_it_can_sign_out_an_authenticated_user()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            "email" => $user->email,
            "password" => "password"
        ]);

        $response->assertStatus(200)

        ->assertJsonStructure([
            "status",
            "message",
            "data" => [
                "id",
                "name",
                "email",
                "email_verified_at",
                "updated_at" ,
                "created_at",
            ],
            "access_token",
            "token_type"
        ]);

        $this->assertAuthenticatedAs($user);

        $token = $response["access_token"];

        $tokenType = $response["token_type"];


        $response = $this->post("/api/logout", [], [
            'Authorization' => "{$tokenType} {$token}"
        ]);

        $response->assertStatus(200)

        ->assertJsonStructure([
            "status",
            "message",
            "data" => [
                "id",
                "name",
                "email",
                "email_verified_at",
                "updated_at" ,
                "created_at",
            ],

        ])

        ->assertJson([
            'status' => 'success',
        ]);

    }
}
