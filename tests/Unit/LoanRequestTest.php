<?php

namespace Tests\Unit;

use App\Models\Loan;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

class LoanRequestTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_repay_amount_is_correct()
    {
        $amount = 50000;

        $term = 52;

        $repay = floatval($amount/$term);

        $this->assertTrue((new Loan)->repayAmount($amount, $term) === $repay);

    }
}
