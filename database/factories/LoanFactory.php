<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'provider' => $this->faker->company(),

            'name' => $this->faker->name(),

            'amount' => ($this->faker->numberBetween(1,10) * 10000),

            'term' => ($this->faker->numberBetween(1,5) * 52),
        ];
    }
}
