<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Industry;

class IndustrySeeder extends Seeder
{
    public function run()
    {
        $industries = [
            'Informatique',
            'Médical',
            'Finance',
            'Éducation',
            'Construction',
            'Commerce',
        ];

        foreach ($industries as $industry) {
            Industry::create([
                'name' => $industry,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
