<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Industry;
use App\Models\Offer;
use App\Models\Sector;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::paginate(8);

        if (Route::currentRouteName() === 'admin.company.index') {
            return view('admin.offer.index', compact('offers'));
        }

        if (request()->has('page') && request()->page > $offers->lastPage()) {
            return redirect()->route('offers.index', ['page' => $offers->lastPage()]);
        }

        $industries = Industry::all('name');
        $locations = Address::all('city');
        $skills = Skill::all('skill_name');
        $sectors = Sector::all('name');
        $companies = Company::all('name');

        return view('offer.index',
            compact('offers', 'industries', 'locations', 'skills', 'sectors', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        return view('offers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([

        ]);

        // TODO : Faire la vérif que Type est bien un de ces input ['CDI', 'CDD', 'Stage', 'Alternance']
        // TODO : Pour l'input Type : Faire un select avec les options ['CDI', 'CDD', 'Stage', 'Alternance']

        Offer::create([

        ]);

        return redirect()->route('offer.index')->with('success', 'Offre créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        if(!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offre non trouvée');
        }

        return view('offer.show', compact('offer'));
        // return response()->json($offer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer = null)
    {
        if(!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offre non trouvée');
        }

//        return view('offer.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        request()->validate([

        ]);
        $offer->update([

        ]);

        return redirect()->route('offer.index')->with('success', 'Offre modifiée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer = null)
    {
        if(!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offre non trouvée');
        }
        $offer->delete();
        return redirect()->route('offer.index')->with('success', 'Offre supprimée');
    }

    public function search(Request $request)
    {
        // Récupération des valeurs des filtres
        $filters = [
            'offer-title' => $request->query('offer-title'),
            'companies'   => (array) $request->query('company', []),
            'industry'    => (array) $request->query('industry', []),
            'location'    => (array) $request->query('location', []),
            'skill'       => (array) $request->query('skill', []),
            'sector'      => (array) $request->query('sector', []),
            'type'        => (array) $request->query('type', []),
        ];

        // Début de la requête
        $query = Offer::query();

        // Filtrer par titre de l'offre
        if (!empty($filters['offer-title'])) {
            $query->where('title', 'like', '%' . $filters['offer-title'] . '%');
        }
        // Filtrer par type d'offre (CDI, CDD, Stage, Alternance)
        if (!empty($filters['type'])) {
            $query->whereIn('type', $filters['type']);
        }

        // Définition des relations et des champs associés
        $relations = [
            'companies'  => 'name',
            'sector'     => 'name',
            'skills'     => 'skill_name'
        ];

        // Appliquer les filtres relationnels dynamiquement
        foreach ($relations as $filterKey => $column) {
            if (!empty($filters[$filterKey])) {
                $query->whereHas($filterKey, fn($q) => $q->whereIn($column, $filters[$filterKey]));
            }
        }

        // Récupération des offres avec pagination
        $offers = $query->paginate(8);

        // Récupération des filtres disponibles
        $companies  = Company::all(['id', 'name']);
        $industries = Industry::all(['name']);
        $locations  = Address::all(['city']);
        $skills     = Skill::all(['skill_name']);
        $sectors    = Sector::all(['name']);

        return view('offer.index', compact('offers', 'companies', 'industries', 'locations', 'skills', 'sectors'));
    }

}
