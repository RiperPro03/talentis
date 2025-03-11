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
        $skillsToAttach = [1, 2, 7, 11, 6, 8, 12];

        // Filtrer les compétences qui existent réellement dans la base de données
        $existingSkills = Skill::whereIn('id', $skillsToAttach)->pluck('id')->toArray();

        $offer->skills()->syncWithoutDetaching($existingSkills);

        $offers = Offer::all();
        $skills = Skill::all();

        // Attacher aléatoirement des compétences aux offres, en vérifiant leur existence
        foreach ($offers as $offer) {
            $randomSkills = $skills->random(rand(1, 3))->pluck('id')->toArray();
            $offer->skills()->syncWithoutDetaching($randomSkills);
        }


    }}
