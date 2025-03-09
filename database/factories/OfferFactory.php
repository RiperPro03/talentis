<?php

namespace Database\Factories;
use App\Models\Company;

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
            'offer_duration'=>$this->faker->text(50),
            'type' => $this->faker->randomElement(['CDI', 'CDD', 'Stage', 'Alternance']),
            'created_at'=>now(),
            'updated_at'=>now(),
            'start_offer' => $this->faker->date,
            'end_offert' => $this->faker->date,
            'company_id'=>Company::inRandomOrder()->first()?->id ?? Company::factory()->create()->id,
            'Id_Sector' => \App\Models\Sector::factory(),
            'Id_Company' => \App\Models\Company::factory(),
        ];
    }
}
