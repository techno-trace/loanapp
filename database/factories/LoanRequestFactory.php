<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $loan = Loan::factory()->create();

        return [

            'loan_id' => $loan->id,

            'user_id' => fn() => User::factory()->create()->id,

            'repay_amount' => floatval($loan->amount/$loan->term),

            'approved' => now(),

            'rejected' => null,

            'held' => null,
        ];
    }
}
