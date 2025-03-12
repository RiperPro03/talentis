<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocatedFactory extends Factory
{
    public function definition()
    {
        return [
            'company_id' => \App\Models\Company::factory(),
            'address_id' => \App\Models\Address::factory(),
        ];
    }
}
