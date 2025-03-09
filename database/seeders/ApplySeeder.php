<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Offer;

class ApplySeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $offers = Offer::all();

        foreach ($users as $user) {
            $offer = $offers->random();
            $user->offers()->attach($offer->id, [
                'cover_letter' => 'Cover letter for offer ' . $offer->id,
            ]);
        }
    }
}
