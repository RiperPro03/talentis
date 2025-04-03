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
        if (Route::currentRouteName() === 'pilot.offer.index') {
            $query = Offer::query();

            // Filtrer par titre
            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->input('title') . '%');
            }

            // Filtrer par salaire minimum
            if ($request->filled('min_salary')) {
                $query->where('base_salary', '>=', $request->input('min_salary'));
            }

            // Filtrer par type d'offre
            if ($request->filled('type')) {
                $query->where('type', $request->input('type'));
            }

            // Filtrer par secteur
            if ($request->filled('sector_id')) {
                $query->where('sector_id', $request->input('sector_id'));
            }

            // Filtrer par nom d'entreprise
            if ($request->filled('company')) {
                $query->whereHas('companies', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->input('company') . '%');
                });
            }

            // Récupération triée et paginée
            $offers = $query->latest()->paginate(10);

            // Récupération des secteurs pour les filtres
            $sectors = Sector::all();

            return view('pilot.offer.index', compact('offers', 'sectors'));

        }

        if ($request->has('offer-title') || $request->has('company') || $request->has('industry')
            || $request->has('location') || $request->has('skill') || $request->has('sector')
            || $request->has('type'))
        {

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
        }

        if (request()->has('page') && request()->page > $offers->lastPage()) {
            return redirect()->route('offer.index', ['page' => $offers->lastPage()]);
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
        $validatedData = $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'base_salary' => 'nullable|numeric|min:0',
                'type' => 'required|in:CDI,CDD,Stage,Alternance',
                'start_offer' => 'required|date|after_or_equal:today',
                'end_offer' => 'nullable|date|after:start_offer',
                'company_id' => 'required|exists:companies,id',
                'sector_id' => 'required|exists:sectors,id',
                'skills' => 'nullable|array',
                'skills.*' => 'string|exists:skills,skill_name',
            ],
            [
                'title.required' => 'Le titre est obligatoire.',
                'title.string' => 'Le titre doit être une chaîne de caractères.',
                'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',

                'description.required' => 'La description est obligatoire.',
                'description.string' => 'La description doit être une chaîne de caractères.',

                'base_salary.numeric' => 'Le salaire doit être un nombre.',
                'base_salary.min' => 'Le salaire doit être supérieur ou égal à 0.',

                'type.required' => 'Le type de contrat est obligatoire.',
                'type.in' => 'Le type de contrat est invalide.',

                'start_offer.required' => 'La date de début est obligatoire.',
                'start_offer.date' => 'La date de début doit être une date valide.',
                'start_offer.after_or_equal' => 'La date de début doit être aujourd\'hui ou ultérieure.',

                'end_offer.date' => 'La date de fin doit être une date valide.',
                'end_offer.after' => 'La date de fin doit être postérieure à la date de début.',

                'company_id.required' => 'L\'entreprise est obligatoire.',
                'company_id.exists' => 'L\'entreprise sélectionnée est invalide.',

                'sector_id.required' => 'Le secteur est obligatoire.',
                'sector_id.exists' => 'Le secteur sélectionné est invalide.',

                'skills.array' => 'Les compétences doivent être un tableau.',
                'skills.*.string' => 'Chaque compétence doit être une chaîne de caractères.',
                'skills.*.exists' => 'Une ou plusieurs compétences sélectionnées sont invalides.',
            ]
        );

        // Création de l'offre
        $offer = Offer::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'base_salary' => $validatedData['base_salary'] ?? null,
            'type' => $validatedData['type'],
            'start_offer' => $validatedData['start_offer'],
            'end_offer' => $validatedData['end_offer'] ?? null,
            'company_id' => $validatedData['company_id'],
            'sector_id' => $validatedData['sector_id'],
        ]);

        // Association des compétences
        if (!empty($validatedData['skills'])) {
            $skillsIds = Skill::whereIn('skill_name', $validatedData['skills'])->pluck('id')->toArray();
            $offer->skills()->sync($skillsIds);
        }

        return redirect()->route('pilot.offer.index')->with('success', 'Offre créée avec succès.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        if (!$offer) {
            return redirect()->route('offer.index')->withErrors(['User' => 'Offre non trouvée.']);
        }

        return view('offer.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        if (!$offer) {
            return redirect()->route('pilot.offer.index')->withErrors(['User' => 'Offre non trouvée.']);
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
        $validatedData = $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'base_salary' => 'nullable|numeric|min:0',
                'type' => 'required|in:CDI,CDD,Stage,Alternance',
                'start_offer' => 'required|date|after_or_equal:today',
                'end_offer' => 'nullable|date|after:start_offer',
                'company_id' => 'nullable|exists:companies,id',
                'sector_id' => 'nullable|exists:sectors,id',
                'skills' => 'nullable|array',
                'skills.*' => 'string|exists:skills,skill_name',
            ],
            [
                'title.required' => 'Le titre est obligatoire.',
                'title.string' => 'Le titre doit être une chaîne de caractères.',
                'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',

                'description.string' => 'La description doit être une chaîne de caractères.',

                'base_salary.numeric' => 'Le salaire doit être un nombre.',
                'base_salary.min' => 'Le salaire doit être supérieur ou égal à 0.',

                'type.required' => 'Le type de contrat est obligatoire.',
                'type.in' => 'Le type de contrat est invalide.',

                'start_offer.required' => 'La date de début est obligatoire.',
                'start_offer.date' => 'La date de début doit être une date valide.',
                'start_offer.after_or_equal' => 'La date de début doit être aujourd\'hui ou ultérieure.',

                'end_offer.date' => 'La date de fin doit être une date valide.',
                'end_offer.after' => 'La date de fin doit être postérieure à la date de début.',

                'company_id.exists' => 'L\'entreprise sélectionnée est invalide.',
                'sector_id.exists' => 'Le secteur sélectionné est invalide.',

                'skills.array' => 'Les compétences doivent être un tableau.',
                'skills.*.string' => 'Chaque compétence doit être une chaîne de caractères.',
                'skills.*.exists' => 'Une ou plusieurs compétences sélectionnées sont invalides.',
            ]
        );

        // Mise à jour des informations de l'offre
        $offer->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
            'base_salary' => $validatedData['base_salary'] ?? null,
            'type' => $validatedData['type'],
            'start_offer' => $validatedData['start_offer'],
            'end_offer' => $validatedData['end_offer'] ?? null,
            'company_id' => $validatedData['company_id'] ?? $offer->company_id,
            'sector_id' => $validatedData['sector_id'] ?? $offer->sector_id,
        ]);

        // Mettre à jour les compétences
        if (!empty($validatedData['skills'])) {
            $skillsIds = Skill::whereIn('skill_name', $validatedData['skills'])->pluck('id')->toArray();
            $offer->skills()->sync($skillsIds);
        } else {
            // Si aucune compétence sélectionnée → désassocier
            $offer->skills()->detach();
        }

        return redirect()->route('pilot.offer.edit', $offer)->with('success', 'Offre mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        if (!$offer) {
            return redirect()->route('pilot.offer.index')->withErrors(['User' => 'Offre non trouvée.']);
        }

        $offer->applies()->delete();
        $offer->delete();

        return redirect()->route('pilot.offer.index')->with('success', 'Offre supprimée avec succès');
    }
}
