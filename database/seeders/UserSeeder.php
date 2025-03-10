<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Promotion;
use App\Models\Address;

class UserSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            $address = Address::inRandomOrder()->first(); // Crée une adresse
            $promotion = Promotion::inRandomOrder()->first(); // Crée une promotion


        User::factory(1)->create([
            'address_id' => $address->id,
            'promotion_id' => $promotion->id,
        ]);


    }}
}
