<?php

namespace Database\Factories;

use App\Models\Apply;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ApplyFactory extends Factory
{
    protected $model = Apply::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'offer_id' => Offer::inRandomOrder()->first()->id ?? Offer::factory()->create()->id,
            'created_at' => Carbon::now(),
            'curriculum_vitae' => $this->faker->word(),
            'cover_letter' => $this->faker->word(),
        ];
    }
}
