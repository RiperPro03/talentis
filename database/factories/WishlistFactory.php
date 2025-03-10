<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WishlistFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => \App\Models\Users::factory(),
            'offer_id' => \App\Models\Offer::factory(),
        ];
    }
}
