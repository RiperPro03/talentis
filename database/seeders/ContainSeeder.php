<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Offer;
use App\Models\Sector;
use App\Models\Skill;
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
        $offer = Offer::find(1);
        $skill = Skill::find(1);
        $offer->skills()->attach($skill);
        $skill = Skill::find(2);
        $offer->skills()->attach($skill);
        $skill = Skill::find(7);
        $offer->skills()->attach($skill);
        $skill = Skill::find(11);
        $offer->skills()->attach($skill);

        $offer = Offer::find(1);
        $skill = Skill::find(6);
        $offer->skills()->attach($skill);
        $skill = Skill::find(8);
        $offer->skills()->attach($skill);
        $skill = Skill::find(12);
        $offer->skills()->attach($skill);



        $offers = Offer::all();
        $skills = Skill::all();



        // Attacher aléatoirement des compétences aux offres
        foreach ($offers as $offer) {
            $randomSkills = $skills->random();
            $offer->skills()->attach($randomSkills);
        }
}}
