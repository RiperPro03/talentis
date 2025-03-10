<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Offer;
use App\Models\Sector;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::all();
        $offers = Offer::all();

        foreach ($users as $user) {
            $offer = $offers->random();
            $user->applies()->attach($offer->id, [
                'curriculum_vitae' => 'CV for offer ' . $offer->id,
                'cover_letter' => 'Cover letter for offer ' . $offer->id,
            ]);
        }
    }
}
