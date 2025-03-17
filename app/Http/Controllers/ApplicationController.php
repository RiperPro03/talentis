<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Afficher le formulaire de candidature
    public function showForm()
    {
        return view('apply.index');  
    }

    // Gérer la soumission du formulaire
    public function submitApplication(Request $request)
    {
        // Valider les données
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'message' => 'nullable|string|max:1000',
        ]);

        
        $cvPath = $request->file('cv')->store('cv', 'public');

        return redirect()->route('apply.form')->with('success', 'Candidature envoyée avec succès!');
    }
}