<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContainFactory extends Factory
{
    public function definition()
    {
        return [
            'Id_Offer' => \App\Models\Offer::factory(),
            'Id_Skill' => \App\Models\Skill::factory(),
        ];
    }
}
