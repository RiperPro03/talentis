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
        $user = User::find(3);
        $offer = Offer::find(2);


        $user->offers()->attach($offer);




        $users = User::all();
        $offers = Offer::all();



        foreach ($users as $user) {
            $randomOffers = $offers->random();
            $user->offers()->attach($randomOffers);
        }

    }

}
