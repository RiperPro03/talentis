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

        
        // // Création des rôles
        // $roles = ['user', 'student', 'pilot', 'admin'];

        // foreach ($roles as $role) {
        //     Role::create(['name' => $role]);
        // }

        // // Création des permissions
        // $permissions = [
        //     'access_dashboard',
        //     'manage_students',
        //     'manage_pilots',
        //     'access_student',
        //     'access_pilot',
        // ];

        // foreach ($permissions as $permission) {
        //     Permission::create(['name' => $permission]);
        // }

        // Attribution des permissions aux rôles
        //Role::findByName('user')->givePermissionTo([]);
        //Role::findByName('student')->givePermissionTo(['access_student']);
        // Role::findByName('pilot')->givePermissionTo(['manage_students', 'access_pilot']);
        // Role::findByName('admin')->givePermissionTo(Permission::all());

        // Création d'un utilisateur admin
        // $admin = User::factory()->create([
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('password'),
        //     'promotion_id'=>NULL,
        // ]);
        // $admin->assignRole('admin');
        $this->call(PromotionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(SkillSeeder::class);
        $this->call(OfferSeeder::class);
    }
}
