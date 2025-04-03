<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        // Index pour voir toutes les candidatures
        if (Route::currentRouteName() === 'pilot.apply.index') {

            if ($request->has('offer_title') || $request->has('candidate') || $request->has('company')) {
                $offerTitle = $request->query('offer_title');
                $candidate = $request->query('candidate');
                $companies = (array) $request->query('company', []);

                $offers = Offer::with(['companies.addresses', 'applies' => function ($query) use ($candidate) {
                    if ($candidate) {
                        $query->where(function ($q) use ($candidate) {
                            $q->where('name', 'like', "%$candidate%")
                                ->orWhere('first_name', 'like', "%$candidate%");
                        });
                    }
                }])
                    ->when($offerTitle, fn($q) => $q->where('title', 'like', "%$offerTitle%"))
                    ->when($companies, function ($q) use ($companies) {
                        $q->whereHas('companies', fn($query) => $query->whereIn('name', $companies));
                    })
                    ->whereHas('applies')
                    ->latest()
                    ->paginate(7);
            } else {
                $offers = Offer::with([
                    'companies.addresses',
                    'applies' => function ($query) {
                        $query->withPivot('curriculum_vitae', 'cover_letter', 'created_at');
                    }
                ])
                    ->whereHas('applies')
                    ->latest()
                    ->paginate(7);
            }

            $companies = Company::all('name');
            return view('pilot.apply.index', compact('offers', 'companies'));
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
        $user = Auth::user();
        if ($user->hasRole('pilot')) {
            return redirect()->route('offer.show', compact('offer'));
        }

        if ($offer->applies()->where('user_id', Auth::id())->exists()) {
            return back()->withErrors(['User' => 'Vous avez déjà postulé à cette offre.']);
        }
        return view('apply.create', compact('offer'));
    }

    public function store(Request $request, Offer $offer)
    {
        $validatedData = $request->validate([
            'cv' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:2048',
            ],
            'cl' => 'nullable|string|max:255',
        ], [
            'cv.required' => 'Le CV est obligatoire.',
            'cv.file' => 'Le fichier doit être un document valide.',
            'cv.mimes' => 'Le CV doit être au format PDF, DOC ou DOCX.',
            'cv.max' => 'Le CV ne doit pas dépasser 2 Mo.',
            'cl.string' => 'La lettre de motivation doit être une chaîne de caractères.',
            'cl.max' => 'La lettre de motivation ne doit pas dépasser 255 caractères.',
        ]);

        $user = Auth::user();

        // Vérifier si l'utilisateur a déjà postulé
        if ($offer->applies()->where('user_id', $user->id)->exists()) {
            return back()->withErrors(['user' => 'Vous avez déjà postulé à cette offre.']);
        }

        // Upload du CV
        $filename = 'cv_' . $user->id . '_' . Str::uuid() . '.' . $request->file('cv')->getClientOriginalExtension();
        $cvPath = $request->file('cv')->storeAs('cv', $filename, 'public');

        // Sauvegarde dans la table pivot applies
        $offer->applies()->attach($user->id, [
            'curriculum_vitae' => $cvPath,
            'cover_letter' => $validatedData['cl'],
        ]);

        return redirect()->route('apply.index')->with('success', 'Candidature envoyée avec succès !');
    }

    public function destroy(Offer $offer, User $user = null)
    {
        if (Route::currentRouteName() === 'pilot.apply.remove') {
            if (!$user || !$user->applies()->where('offer_id', $offer->id)->exists()) {
                return redirect()->route('pilot.apply.index')->withErrors([
                    'error' => 'La candidature n\'existe pas ou est introuvable.'
                ]);
            }

            $application = $user->applies()->where('offer_id', $offer->id)->first();
            $cvPath = $application->pivot->curriculum_vitae;

            if ($cvPath && Storage::disk('public')->exists($cvPath)) {
                Storage::disk('public')->delete($cvPath);
            }

            $user->applies()->detach($offer->id);

            return redirect()->route('pilot.apply.index')->with('success', 'Candidature retirée avec succès.');
        }

        $user = auth()->user();

        $application = $user->applies()->where('offer_id', $offer->id)->first();

        if (!$application) {
            return redirect()->route('apply.index')->withErrors([
                'error' => 'Impossible de retirer cette candidature. Elle est introuvable.'
            ]);
        }

        $cvPath = $application->pivot->curriculum_vitae;

        if ($cvPath && Storage::disk('public')->exists($cvPath)) {
            Storage::disk('public')->delete($cvPath);
        }

        $user->applies()->detach($offer->id);

        return redirect()->route('apply.index')->with('success', 'Candidature retirée avec succès.');
    }
}
