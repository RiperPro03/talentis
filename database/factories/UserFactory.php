<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Promotion;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'profile_picture_path' => $this->faker->imageUrl(),
            'name' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'birthdate' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Par défaut, tous les users auront 'password' comme mot de passe
            'promotion_id' => \App\Models\Promotion::factory(),
            'created_at' => now(),
            'updated_at' => now(),
            'address_id' => \App\Models\Address::factory(),

        ];
    }
}
