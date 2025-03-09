<?php

namespace Database\Factories;


namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name'=>$this->faker->company,
            'logo_path'=>$this->faker->imageUrl(200,200,'people'),
            'description'=>$this->faker->company . ' se spécialise dans ' . $this->faker->bs . ' pour transformer l’industrie.',
            'email'=>$this->faker->unique()->companyEmail,
            'phone_number'=>$this->faker->unique()->numerify('06########'),
            'created_at'=>now(),
            'updated_at'=>now(),
            //
        ];
    }
}


