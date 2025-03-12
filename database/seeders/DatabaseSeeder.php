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
        $this->call([
            CompanySeeder::class,
            AddressSeeder::class,
            IndustrySeeder::class,
            PromotionSeeder::class,
            SectorSeeder::class,
            SkillSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            OfferSeeder::class,
            ApplySeeder::class,

            EvaluateSeeder::class,
            LocateSeeder::class,
            ContainSeeder::class,
            WishlistSeeder::class,
            WorkSeeder::class,
        ]);

        // Création d'un utilisateur admin
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole('admin');

        // Création d'un utilisateur pilote
        $pilot = User::factory()->create([
            'email' => 'pilot@exemple.com',
            'password' => bcrypt('password')
        ]);
        $pilot->assignRole('pilot');

        // Création d'un utilisateur étudiant
        $student = User::factory()->create([
            'email' => 'etu@exemple.com',
            'password' => bcrypt('password')
        ]);
        $student->assignRole('student');
    }
}
