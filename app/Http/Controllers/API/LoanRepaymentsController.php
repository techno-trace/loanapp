<?php

namespace App\Http\Controllers\API;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LoanRepayment;
use App\Models\LoanRequest;
use Illuminate\Support\Facades\Validator;

class LoanRepaymentsController extends Controller
{

    /**
     * LoanRepaymentsController constructor.
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
    public function repay(Request $request, LoanRequest $loanRequest)
    {

        /* Authorize user for the loan request created */

        $this->authorize('repay', $loanRequest);

        /*

        If Amount is chosen by user then we need to validate

        $validator = Validator::make($request->all(), [

            'amount' => 'bail|required|numeric',
        ]);

        if ($validator->fails()) {

            return response()->json(['status' => 'failure', 'errors' => $validator->errors()]);

        }

        */

        return $loanRequest->repayments()->create(['user_id' => auth()->id(), 'amount' => $loanRequest->repay_amount]);
    }
}
