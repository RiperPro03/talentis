<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Offer;

class ApplySeeder extends Seeder
{
    public function run()
    {
        $user=User::find(1);
        $offer=Offer::find(1);
        $user->applies()->attach($offer->id, ['curriculum_vitae' => 'Mon CV',
            'cover_letter' => 'Je suis motivé']);

        $user=User::find(2);
        $offer=Offer::find(2);
        $user->applies()->attach($offer->id, ['curriculum_vitae' => 'Mon CV',
            'cover_letter' => 'Je suis motivé']);$user=User::find(1);

        $offer=Offer::find(1);
        $offer=Offer::find(2);
        $user->applies()->attach($offer->id, ['curriculum_vitae' => 'Mon CV',
            'cover_letter' => 'Je suis motivé']);}}

/*
        $users = User::all();
        $offers = Offer::all();}}

        foreach ($users as $user) {
            $offer = $offers->random();
            $user->applies()->attach($offer->id, [
                'curriculum_vitae' => 'CV for offer ' . $offer->id,
                'cover_letter' => 'Cover letter for offer ' . $offer->id,
            ]);
        }


    }
}*/
