<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanRequestManagerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_authenticated_user_can_request_a_loan()
    {

        /*

            Given a user has logged in

        */

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

        $loan = Loan::factory()->create();

        /*
            When we create a new loan request
        */

        $response = $this->post("api/loans/{$loan->id}/request", [], [
            'Authorization' => "{$tokenType} {$token}"
        ]);



        /*
            Then
        */

        $response->assertStatus(201)

        ->assertJsonStructure([
            "id",
            "user_id",
            "repay_amount",
            "approved",
            "loan_id",
            "updated_at",
            "created_at"
        ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_unauthenticated_user_cannot_request_a_loan()
    {

        /*
          Given
        */

        $loan = Loan::factory()->create();

        /*
            When we create a new loan request
        */

        $response = $this->post("api/loans/{$loan->id}/request");


        /*
            Then
        */

        $response->assertStatus(404)

        ->assertJsonStructure([

            "message",

        ])->assertJson(['message' => "Invalid Operation"]);
    }
}
