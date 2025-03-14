<?php

namespace Database\Factories;
use App\Models\Company;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=> $this -> faker -> jobTitle,
            'description'=>$this -> faker -> text(255),
            'base_salary'=>$this -> faker -> numberBetween(30000, 100000),
            'type' => $this->faker->randomElement(['CDI', 'CDD', 'Stage', 'Alternance']),
            'created_at'=>now(),
            'updated_at'=>now(),
            'start_offer' => $this->faker->date,
            'end_offer' => $this->faker->date,
            'company_id'=>Company::inRandomOrder()->first()?->id ?? Company::factory()->create()->id,
            'sector_id' => Sector::factory(),
        ];
    }
}
