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
        $roles = [
            'student',
            'pilot',
            'admin'
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Création des permissions
        $permissions = [
            'access_dashboard',
            'manage_students',
            'manage_pilots',
            'manage_company',
            'manage_offers',
            'manage_apply', // Gestion des candidatures des étudiants (admin) et gestion des candidatures de ses offres (etudiant)
            'manage_promotions',

            'access_apply',
            'access_wishlist',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Attribution des permissions aux rôles
        Role::findByName('student')->givePermissionTo(['access_apply', 'access_wishlist']);
        Role::findByName('pilot')->givePermissionTo(['manage_students', 'access_pilot', 'manage_company', 'manage_offers']);
        Role::findByName('admin')->givePermissionTo(Permission::all());
    }
}
