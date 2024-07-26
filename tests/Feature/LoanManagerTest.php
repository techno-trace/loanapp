<?php

namespace Tests\Feature;

use App\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_shows_all_loans()
    {
        /* Given */
        Loan::factory(10)->create();

        /* When */
        $response = $this->get('/api/loans');

        /* Then */
        $response->assertJsonCount(10);
    }

    public function test_it_shows_single_loan()
    {
        /* Given */
        $loan = Loan::factory()->create();

        /* When */
        $response = $this->get('/api/loans/' . $loan->id);

        /* Then */
        $response->assertJson($loan->toArray());
    }
}
