<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Promotion;
use App\Models\Address;

class UserSeeder extends Seeder
{
    public function run()
    {
        $roleAdmin = Role::where('role_name', 'Admin')->first();
        $roleUser = Role::where('role_name', 'User')->first();

        $address = Address::factory()->create(); // Crée une adresse
        $promotion = Promotion::factory()->create(); // Crée une promotion

        // Crée 5 utilisateurs de rôle "User"
        User::factory(5)->create([
            'Id_Role' => $roleUser->id,
            'Id_Address' => $address->id,
            'Id_Promotion' => $promotion->id,
        ]);

        // Crée 1 utilisateur de rôle "Admin"
        User::factory(1)->create([
            'Id_Role' => $roleAdmin->id,
            'Id_Address' => $address->id,
            'Id_Promotion' => $promotion->id,
        ]);
    }
}
