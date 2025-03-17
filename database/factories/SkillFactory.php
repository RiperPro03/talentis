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
        static $competences = [
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

        if (empty($competences)) {
            throw new \Exception("Toutes les compétences ont été utilisées !");
        }

        $skill_name = array_splice($competences, array_rand($competences), 1)[0];

        return [
            'skill_name' => $skill_name,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
