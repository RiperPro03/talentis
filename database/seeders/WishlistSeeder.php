<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Offer;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $offers = Offer::all();



        foreach ($users as $user) {
            $randomOffers = $offers->random();
            $user->offers()->attach($randomOffers);
        }

    }

}
