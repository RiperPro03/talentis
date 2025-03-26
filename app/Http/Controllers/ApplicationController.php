<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function index()
    {
        // Index pour voir toutes les candidatures
        if (Route::currentRouteName() === 'pilot.apply.index') {

        }

        // Index pour voir ses propre candidatures
        $user = auth()->user();
        $applies = $user->applies()->with(['companies.addresses'])
            ->orderByPivot('created_at', 'desc')->paginate(7);

        return view('apply.index', compact('applies'));
    }

    // Afficher le formulaire de candidature
    public function create(Offer $offer)
    {
        if ($offer->applies()->where('user_id', Auth::id())->exists()) {
            return back()->with('errors', 'Vous avez déjà postulé à cette offre.');
        }
        return view('apply.create', compact('offer'));
    }

    public function store(Request $request, Offer $offer)
    {
        // Valider les données
        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cl' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        //vérifier si l'utilisateur a déjà postulé
        if ($offer->applies()->where('user_id', $user->id)->exists()) {
            return back()->with('errors', 'Vous avez déjà postulé à cette offre.');
        }

        $file = $request->file('cv');
        $extension = $file->getClientOriginalExtension();
        $filename = 'cv_' . $user->id . '_' . Str::uuid() . '.' . $extension;

        $cvPath = $file->storeAs('cv', $filename, 'public');

        // Vérifie si l'utilisateur a déjà postulé
        if ($offer->applies()->where('user_id', $user->id)->exists()) {
            return back()->with('errors', 'Vous avez déjà postulé à cette offre.');
        }

        // Enregistrer l'application dans la table pivot `applies`
        $offer->applies()->attach($user->id, [
            'curriculum_vitae' => $cvPath,
            'cover_letter' => $request->input('cl'),
        ]);


        return redirect()->route('offer.show',$offer)->with('success', 'Candidature envoyée avec succès!');
    }
}
