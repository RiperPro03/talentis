<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $competences = [
            'Développement web',
            'JavaScript',
            'PHP',
            'Python',
            'Java',
            'C++',
            'SQL',
            'DevOps',
            'Analyse de données',
            'Machine Learning',
            'UI/UX Design',
            'Gestion de projet',
            'Marketing digital',
            'Réseaux et sécurité'
        ];
        return [
            'skill_name' => $this-> faker ->randomElement($competences),
            'created_at'=>now(),
            'updated_at'=>now(),
            //
        ];
    }
}
