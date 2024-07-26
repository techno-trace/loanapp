<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{
    use HasFactory;

    protected $fillable = ['loan_request_id', 'user_id', 'amount'];

    public function borrower(){

        return $this->belongsTo(User::class, 'user_id');
    }

    public function loan(){

        return $this->belongsTo(LoanRequest::class, 'loan_request_id');
    }
}
