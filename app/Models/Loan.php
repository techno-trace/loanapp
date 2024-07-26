<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['provider', 'name', 'amount', 'term'];

    public function requests()
    {
        return $this->hasMany(LoanRequest::class);
    }

    public function repayAmount(float $amount, int $term): float|int
    {
        return floatval($amount/$term);
    }
}
