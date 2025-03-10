<?php

namespace Database\Factories;

use App\Models\Evaluate;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluateFactory extends Factory
{
    protected $model = Evaluate::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\Users::factory(),
            'company_id' => \App\Models\Company::factory(),
            'rating' => $this->faker->numberBetween(1, 10),
        ];
    }
}
