<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WishlistFactory extends Factory
{
    public function definition()
    {
        return [
            'Id_User' => \App\Models\Users::factory(),
            'Id_Offer' => \App\Models\Offer::factory(),
        ];
    }
}
