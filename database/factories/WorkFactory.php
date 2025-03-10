<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFactory extends Factory
{
    public function definition()
    {
        return [
            'company_id' => \App\Models\Company::factory(),
            'industry_id' => \App\Models\Industry::factory(),
        ];
    }
}
