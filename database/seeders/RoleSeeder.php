<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création des rôles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $pilot = Role::firstOrCreate(['name' => 'Pilote']);
        $student = Role::firstOrCreate(['name' => 'Etudiant']);

        // Création des permissions
        $permissions = [
            'access_dashboard',
            'manage_students',
            'manage_pilots',
            'access_student',
            'access_pilot',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Attribution des permissions aux rôles
        $student->givePermissionTo(['access_student']);
        $pilot->givePermissionTo(['manage_students', 'access_pilot']);
        $admin->givePermissionTo(Permission::all());

        // Création d'un utilisateur admin
        $adminUser = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $adminUser->assignRole('Admin');
    }
}
