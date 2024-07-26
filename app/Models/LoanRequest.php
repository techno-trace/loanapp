<?php

namespace App\Models;

use App\Casts\Boolean;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    use HasFactory;

    protected $fillable = ['loan_id', 'user_id', 'repay_amount', 'approved', 'rejected', 'held'];

    protected $with = ['borrower', 'loan', 'repayments'];

    protected $cast = [

        'approved' => Boolean::class,

        'rejected' => Boolean::class,

        'held' => Boolean::class,
    ];

    public function borrower(){

        return $this->belongsTo(User::class, 'user_id');
    }

    public function loan(){

        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function repayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }
}
