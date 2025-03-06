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
            'name'=>$this->faker->Name(),
            'logo_path'=>$this->faker->imageUrl(200,200,'people'),
            'description'=>$this->faker->text(255),
            'email'=>$this->faker->unique()->safeEmail(),
            'phone_number'=>$this->faker->unique()->e164phoneNumber(),
            'created_at'=>now(),
            'updated_at'=>now(),
            //
        ];
    }
}
