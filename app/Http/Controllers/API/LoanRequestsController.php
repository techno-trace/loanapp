<?php

namespace App\Http\Controllers\API;

use App\Models\Loan;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoanRequestsController extends Controller
{
    /**
     * LoanRequestsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function request(Request $request, Loan $loan)
    {
        /* Create a new loan request with the authenticated user */

        return $loan->requests()->create([

            'user_id' => auth()->id(),

            'repay_amount' => $loan->repayAmount($loan->amount, $loan->term),

            'approved' => now()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LoanRequest  $loanRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LoanRequest $loanRequest)
    {
        return $loanRequest->update(['approved' => now()]);
    }
}
