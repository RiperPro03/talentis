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
        $offers = Offer::all();
        $skills = Skill::all();



        // Attacher aléatoirement des compétences aux offres
        foreach ($offers as $offer) {
            $randomSkills = $skills->random();
            $offer->skills()->attach($randomSkills);
        }
}}
