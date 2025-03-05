<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Promotion;
use App\Models\Role;

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
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Par défaut, tous les users auront 'password' comme mot de passe
            'promotion_id' => Promotion::inRandomOrder()->first()?->id ?? Promotion::factory()->create()->id,
            'role_id' => Role::inRandomOrder()->first()?->id ?? Role::factory()->create()->id,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
