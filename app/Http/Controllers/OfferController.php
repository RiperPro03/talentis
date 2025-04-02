<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Sector;
use App\Models\Skill;
use App\Models\Offer;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (
            $request->has('offer-title') || $request->has('company') || $request->has('industry')
            || $request->has('location') || $request->has('skill') || $request->has('sector')
            || $request->has('type')
        ) {


            $request->validate([
                'offer-title' => 'string|nullable',
                'company'     => 'array|nullable',
                'industry'    => 'array|nullable',
                'location'    => 'array|nullable',
                'skill'       => 'array|nullable',
                'sector'      => 'array|nullable',
                'type'        => 'array|nullable',
                'type.*'      => 'in:CDI,CDD,Stage,Alternance',
            ]);

            $filters = [
                'offer-title' => $request->query('offer-title'),
                'company'     => (array) $request->query('company', []),
                'industry'    => (array) $request->query('industry', []),
                'location'    => (array) $request->query('location', []),
                'skill'      => (array) $request->query('skill', []),
                'sector'     => (array) $request->query('sector', []),
                'type'       => (array) $request->query('type', []),
            ];

            $query = Offer::query();

            if (!empty($filters['offer-title'])) {
                $query->where('title', 'like', '%' . $filters['offer-title'] . '%');
            }

            if (!empty($filters['type'])) {
                $query->whereIn('type', $filters['type']);
            }

            $relations = [
                'companies'  => 'company',
                'sector'     => 'sector',
                'skills'     => 'skill',
                'companies.industries' => 'industry',
                'companies.addresses'  => 'location',
            ];

            foreach ($relations as $relation => $filterKey) {
                if (!empty($filters[$filterKey])) {
                    $query->whereHas($relation, function ($q) use ($filters, $filterKey) {
                        $column = match ($filterKey) {
                            'company'  => 'name',
                            'sector'   => 'name',
                            'skill'    => 'skill_name',
                            'industry' => 'name',
                            'location' => 'city',
                        };
                        $q->whereIn($column, $filters[$filterKey]);
                    });
                }
            }

            $offers = $query->paginate(8);
        } else {
            $offers = Offer::paginate(8);


            if (Route::currentRouteName() === 'pilot.offer.index') {
                return view('pilot.offer.index', compact('offers'));
            }

            if (request()->has('page') && request()->page > $offers->lastPage()) {
                return redirect()->route('offer.index', ['page' => $offers->lastPage()]);
            }

            $industries = Industry::all();
            $locations = Address::all();
            $skills = Skill::all('skill_name');
            $sectors = Sector::all('name');
            $companies = Company::all('name');

            return view('offer.index', compact('offers', 'skills', 'sectors', 'companies', 'industries', 'locations'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skills = Skill::all(['skill_name']);
        $sectors = Sector::all(['id', 'name']);  // Récupère aussi l'id et le nom
        $companies = Company::all(['id', 'name']);  // Récupère aussi l'id et le nom

        return view('pilot.offer.create', compact('skills', 'sectors', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        // Valider les données de la requête
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'base_salary' => 'nullable|numeric|min:0',
            'type' => 'required|in:CDI,CDD,Stage,Alternance',
            'start_offer' => 'required|date|after_or_equal:today',
            'end_offer' => 'date|after:start_offer',
            'company_id' => 'required|exists:companies,id',
            'sector_id' => 'required|exists:sectors,id',
        ]);

        // Créer l'offre
        $offer = Offer::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'base_salary' => $request->input('base_salary'),
            'type' => $request->input('type'),
            'start_offer' => $request->input('start_offer'),
            'end_offer' => $request->input('end_offer'),
            'company_id' => $request->input('company_id'),
            'sector_id' => $request->input('sector_id'),
        ]);

        if ($request->has('skills')) {
            // Récupérer les IDs des skills en fonction des noms envoyés
            $skillsIds = Skill::whereIn('skill_name', $request->input('skills'))->pluck('id')->toArray();
        
            // Associer les compétences à l'offre
            $offer->skills()->sync($skillsIds);
        }
        


        // Rediriger vers la liste des offres avec un message de succès
        return redirect()->route('pilot.offer.index')->with('success', 'Offre créée avec succès.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        if (!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offre non trouvée');
        }

        return view('offer.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        if (!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offre non trouvée');
        }

        // Récupérer les secteurs et entreprises disponibles
        $skills = Skill::all('skill_name');
        $sectors = Sector::all('id', 'name');  // Ajouter l'ID du secteur
        $companies = Company::all('id', 'name'); // Ajouter l'ID de l'entreprise

        return view('pilot.offer.edit', compact('offer', 'skills', 'sectors', 'companies'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        
        // Valider les données de la requête
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_salary' => 'nullable|numeric',
            'type' => 'required|string',
            'start_offer' => 'required|date',
            'end_offer' => 'nullable|date',
            'company_id' => 'nullable|exists:companies,id',
            'sector_id' => 'nullable|exists:sectors,id',
        ]);

        // Vérifier et mettre à jour le `company_id` et le `sector_id` si nécessaire
        if ($request->filled('company_id')) {
            $offer->company_id = $request->company_id;
        }

        if ($request->filled('sector_id')) {
            $offer->sector_id = $request->sector_id;
        }

        // Mettre à jour les informations de l'offre
        $offer->update($validatedData);

        // Mettre à jour les compétences liées à l'offre
        if ($request->has('skills')) {
            // Récupérer les IDs des skills en fonction des noms envoyés
            $skillsIds = Skill::whereIn('skill_name', $request->input('skills'))->pluck('id')->toArray();
        
            // Associer les compétences à l'offre
            $offer->skills()->sync($skillsIds);
        }

        // Rediriger vers la page d'édition de l'offre avec un message de succès
        return redirect()->route('pilot.offer.edit', $offer)->with('success', 'Offre mise à jour avec succès.');
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        if (!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offre non trouvée');
        }

        $offer->delete();

        return redirect()->route('offer.index')->with('success', 'Offre supprimée avec succès');
    }

    public function search(Request $request)
    {
        // Récupération des valeurs des filtres
        $filters = [
            'offer-title' => $request->query('offer-title'),
            'company' => (array) $request->query('company', []),
            'sector' => (array) $request->query('sector', []),
            'skill' => (array) $request->query('skill', []),
        ];

        // Début de la requête
        $query = Offer::query();

        // Filtrer par titre de l'offre
        if (!empty($filters['offer-title'])) {
            $query->where('title', 'like', '%' . $filters['offer-title'] . '%');
        }

        // Filtrage par entreprise, secteur et compétences
        $relations = [
            'companies' => 'name',
            'sector' => 'name',
            'skills' => 'skill_name',
        ];

        foreach ($relations as $filterKey => $column) {
            if (!empty($filters[$filterKey])) {
                $query->whereHas($filterKey, fn($q) => $q->whereIn($column, $filters[$filterKey]));
            }
        }

        // Récupérer les offres avec pagination
        $offers = $query->paginate(8);

        // Récupérer les filtres disponibles
        $companies = Company::all(['id', 'name']);
        $sectors = Sector::all(['name']);
        $skills = Skill::all(['skill_name']);

        return view('offer.index', compact('offers', 'companies', 'sectors', 'skills'));
    }
}
