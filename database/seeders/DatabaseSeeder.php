<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

//        $this->call(PromotionSeeder::class);
//        $this->call(UserSeeder::class);
//        $this->call(CompanySeeder::class);
//        $this->call(SkillSeeder::class);
//        $this->call(OfferSeeder::class);

        // Création des rôles



        $this->call([
            CompanySeeder::class,
            SkillSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            OfferSeeder::class,
            ApplySeeder::class,
            AddressSeeder::class,
            IndustrySeeder::class,
            PromotionSeeder::class,
            SectorSeeder::class,
            EvaluateSeeder::class,
            LocateSeeder::class,
        ]);

    }
}
