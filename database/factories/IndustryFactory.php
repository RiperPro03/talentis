<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IndustryFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->companySuffix,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
