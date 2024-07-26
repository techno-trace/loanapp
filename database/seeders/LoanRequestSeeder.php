<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoanRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\LoanRequest::factory(10)->create();
    }
}
