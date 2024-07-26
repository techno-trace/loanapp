<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\LoanRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanRepaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $loanRequest = LoanRequest::factory()->create();

        return [

            'loan_request_id' => $loanRequest->id,

            'user_id' => fn() => User::factory()->create()->id,

            'amount' => $loanRequest->repay_amount,
        ];
    }
}
