<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run()
    {
        Skill::factory()->count(5)->create(); // Crée 10 compétences aléatoires en utilisant la factory
    }
}
