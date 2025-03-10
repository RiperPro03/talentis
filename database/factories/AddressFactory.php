<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition()
    {
        return [
            'postal_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
