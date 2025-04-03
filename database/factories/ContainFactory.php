<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContainFactory extends Factory
{
    public function definition()
    {
        return [
            'offer_id' => \App\Models\Offer::factory(),
            'skill_id' => \App\Models\Skill::factory(),
        ];
    }
}
