<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Loan;
use App\Models\User;
use App\Models\LoanRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanRepaymentManagerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

     /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_authenticated_user_can_repay_a_loan()
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

        $loanRequest = LoanRequest::factory()->create([

            'loan_id' => $loan->id,

            'user_id' => $user->id,

            'repay_amount' => floatval($loan->amount/$loan->term),

            'approved' => now(),

            'rejected' => null,

            'held' => null,
        ]);

        /*
            And we try to repay loan
        */

        $response = $this->post("api/loans/{$loanRequest->id}/repay", [], [
            'Authorization' => "{$tokenType} {$token}"
        ]);



        /*
            Then
        */

        $response->assertStatus(201)

        ->assertJsonStructure([
            "id",
            "user_id",
            "loan_request_id",
            "amount",
            "updated_at",
            "created_at"
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_unauthenticated_user_cannot_repay_a_loan()
    {
        /*

        Here I've used random number because unauthenticated users won't have loan request id

        and thus not able to do anything.

        Ideally this method has no purpose but just tests whether it fails on wrong input

        */


        $response = $this->post("api/loans/{$this->faker()->randomNumber(1)}/repay");

        $response->assertStatus(404)

        ->assertJsonStructure([

            "message",

        ])->assertJson(['message' => "Invalid Operation"]);
    }
}
