<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateAdminUser extends Command
{
    /**
     * Nom et signature de la commande.
     *
     * @var string
     */
    protected $signature = 'make:admin {email} {--name=} {--first-name=} {--password=}';

    /**
     * Description de la commande.
     *
     * @var string
     */
    protected $description = 'Créer un utilisateur administrateur avec un email, un nom, un prénom et un mot de passe';

    /**
     * Exécution de la commande.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->option('name') ?? 'Admin';
        $firstName = $this->option('first-name') ?? null; // Ajout de first_name défini à null si non précisé
        $password = $this->option('password') ?? 'admin123';

        // Vérifier si l'utilisateur existe déjà
        if (User::where('email', $email)->exists()) {
            $this->error("Un utilisateur avec l'email $email existe déjà !");
            return;
        }

        // Création de l'utilisateur
        $user = User::create([
            'name' => $name,
            'first_name' => $firstName,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Vérifier si le rôle admin existe, sinon le créer
        $role = Role::findByName('admin', 'web'); // Spatie utilise 'web' comme guard par défaut
        if (!$role) {
            $role = Role::create(['name' => 'admin']);
        }

        // Assigner le rôle admin à l'utilisateur
        $user->assignRole($role);

        $this->info("Utilisateur administrateur créé avec succès !");
        $this->info("Email: $email");
        $this->info("Nom: $name");
        $this->info("Prénom: " . ($firstName ?? 'Non défini'));
        $this->info("Mot de passe: $password");
    }
}
