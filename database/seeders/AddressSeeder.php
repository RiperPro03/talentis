<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressSeeder extends Seeder
{
    public function run()
    {
        Address::create([
            'postal_code' => '75001',
            'city' => 'Paris',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Address::create([
            'postal_code' => '69001',
            'city' => 'Lyon',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Address::factory()->count(5)->create();
    }
}
