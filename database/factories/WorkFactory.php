<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFactory extends Factory
{
    public function definition()
    {
        return [
            'Id_Company' => \App\Models\Company::factory(),
            'Id_Industry' => \App\Models\Industry::factory(),
        ];
    }
}
