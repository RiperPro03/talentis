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
        for ($i = 1; $i <= 10; $i++) {

            $sector = Sector::inRandomOrder()->first(); // Sélectionne un secteur aléatoire
        $company = Company::inRandomOrder()->first(); // Sélectionne une compagnie aléatoire
        Offer::factory(1)->create([

            'sector_id' => $sector->id,
            'company_id' => $company->id,
        ]);
    }
    }

}
