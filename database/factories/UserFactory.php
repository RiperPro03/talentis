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
        $role = Role::inRandomOrder()->first();
        return [
            'profile_picture_path' => $this->faker->imageUrl(),
            'name' => $this->faker->lastName(),
            'first_name' => $this->faker->firstName(),
            'birthdate' => $this->faker->date(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Par défaut, tous les users auront 'password' comme mot de passe
            'promotion_id' => Promotion::inRandomOrder()->first()?->id ?? Promotion::factory()->create()->id,
            'created_at' => now(),
            'updated_at' => now(),
            'Id_Address' => \App\Models\Address::factory(),
            'Id_Promotion' => \App\Models\Promotion::factory(),
            'Id_Role' => $role ? $role->id : null,
        ];
    }
}
