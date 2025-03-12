<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Exemple de données pour les utilisateurs
        $pilot = collect([
            (object) ['id' => 1, 'name' => 'Jean Dupont', 'email' => 'jean@exemple.com'],
            (object) ['id' => 2, 'name' => 'Marie Durand', 'email' => 'marie@exemple.com'],
            (object) ['id' => 3, 'name' => 'Paul Martin', 'email' => 'paul@exemple.com'],
        ]);

        $offer = collect([]);
        $company = collect([]);
        $student = collect([]);
        $apply = collect([]);
        $wishlist = collect([]);

        // Retourner la vue avec la variable $users
        return view('dashboard.show', ['pilot' => $pilot, 'offer' => $offer, 'company' => $company, 'student' => $student, 'apply' => $apply, 'wishlist' => $wishlist]);
    }
}



