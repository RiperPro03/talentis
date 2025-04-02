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
            'manage_students',
            'manage_company',
            'manage_offers',

            'access_dashboard',
            'access_apply',
            'access_wishlist',
            'access_rate',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Attribution des permissions aux rôles
        Role::findByName('student')->givePermissionTo(['access_apply', 'access_wishlist', 'access_rate']);
        Role::findByName('pilot')->givePermissionTo(['manage_students', 'access_dashboard', 'manage_company', 'manage_offers']);
        Role::findByName('admin')->givePermissionTo(Permission::all());
    }
}
