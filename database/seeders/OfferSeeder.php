<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;
use App\Models\Sector;
use App\Models\Company;

class OfferSeeder extends Seeder
{
    public function run()
    {
        $sector = Sector::inRandomOrder()->first(); // Sélectionne un secteur aléatoire
        $company = Company::inRandomOrder()->first(); // Sélectionne une compagnie aléatoire

        Offer::factory(10)->create([
            'Id_Sector' => $sector->id,
            'Id_Company' => $company->id,
        ]);
    }
}
