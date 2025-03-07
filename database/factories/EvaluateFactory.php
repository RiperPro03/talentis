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
            'user_id' => $this->faker->randomNumber(),
            'company_id' => $this->faker->randomNumber(),
            'rating' => $this->faker->randomNumber(),
        ];
    }
}
