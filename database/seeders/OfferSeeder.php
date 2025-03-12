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
        Offer::create([
            'title' => 'Développeur web',
            'description' => 'Développeur web pour le nouveau site lego.com',
            'type' => 'CDI',
            'base_salary' => 30000,
            'sector_id' => 6,
            'company_id' => 2,
            'start_offer' => '2025-08-28',
        ]);
        Offer::create([
            'title' => 'Développeur logiciel',
            'type'=> 'Stage',
            'description' => 'Mise en place d\'un logiciel de gestion des employés afin de maximisier la productivité et le profit, en minimisant l\'inmpact des droits de l\'homme',
            'base_salary' => 15000,
            'sector_id' => 1,
            'company_id' => 1,
            'start_offer' => '2025-04-28',
        ]);
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
