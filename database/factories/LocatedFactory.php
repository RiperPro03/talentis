<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocatedFactory extends Factory
{
    public function definition()
    {
        return [
            'Id_Company' => \App\Models\Company::factory(),
            'Id_Address' => \App\Models\Address::factory(),
        ];
    }
}
