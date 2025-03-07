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
            'title'=> $this -> faker -> text(50),
            'description'=>$this -> faker -> text(255),
            'base_salary'=>$this -> faker -> random_int(500,10000),
            'offer_duration'=>$this->faker->text(50),
            'created_at'=>now(),
            'updated_at'=>now(),
            'company_id'=>Company::inRandomOrder()->first()?->id ?? Company::factory()->create()->id,
        ];
    }
}
