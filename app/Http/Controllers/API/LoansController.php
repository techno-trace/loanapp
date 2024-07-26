<?php

namespace App\Http\Controllers\API;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoansController extends Controller
{

     /**
     * LoansController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('userLoans');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Loan::latest()->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        return $loan;
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function userLoans(){

        /* Fetch all user loans using property defined in Loan */

        return auth()->user()->loans;
    }
}
