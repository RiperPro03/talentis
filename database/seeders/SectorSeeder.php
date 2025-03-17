<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sector;

class SectorSeeder extends Seeder
{
    public function run()
    {
        $sectors = [
            'Développement logiciel',
            'Marketing',
            'Design',
            'Gestion de projet',
            'Analyse de données',
            'Développement web',
        ];

        foreach ($sectors as $sector) {
            Sector::create([
                'name' => $sector,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
