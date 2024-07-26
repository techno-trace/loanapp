<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoanRepaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\LoanRepayment::factory(10)->create();
    }
}
