<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if (Route::currentRouteName() === 'pilot.company.index') {
            $query = Company::query();

            // Vérifier si un filtre par nom est appliqué
            if ($request->has('name') && !empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            $companies = $query->latest()->paginate(10);

            return view('pilot/company.index', compact('companies'));
        }

        if ($request->has('company') || $request->has('industry') || $request->has('location')) {
            $request->validate([
                'company'  => 'array|nullable',
                'industry' => 'array|nullable',
                'location' => 'array|nullable'
            ]);

            $filters = [
                'company'  => (array) $request->query('company', []),
                'industry' => (array) $request->query('industry', []),
                'location' => (array) $request->query('location', [])
            ];

            $query = Company::query();

            if (!empty($filters['company'])) {
                $query->whereIn('name', $filters['company']);
            }

            $relations = [
                'industries' => 'industry',
                'addresses'  => 'location'
            ];

            foreach ($relations as $relation => $filterKey) {
                if (!empty($filters[$filterKey])) {
                    $query->whereHas($relation, function ($q) use ($filters, $filterKey) {
                        $column = $filterKey === 'industry' ? 'name' : 'city';
                        $q->whereIn($column, $filters[$filterKey]);
                    });
                }
            }

            $companies = $query->paginate(8);
        } else {
            $companies = Company::paginate(8);
        }

        if (request()->has('page') && request()->page > $companies->lastPage()) {
            return redirect()->route('company.index', ['page' => $companies->lastPage()]);
        }

        $industries = Industry::all('name');
        $locations = Address::all('city');

        return view('company.index', compact('companies', 'industries', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = Industry::all();
        return view('pilot.company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'email' => 'required|email:companies,email',
                'phone_number' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9]{10,15}$/'],
                'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'postal_code' => ['nullable', 'string', 'max:10', 'regex:/^\d{5}$/'],
                'city' => ['nullable', 'string', 'max:255'],
                'industry_id' => 'nullable|exists:industries,id',
            ],
            [
                'name.required' => 'Le nom de l\'entreprise est obligatoire.',
                'name.string' => 'Le nom doit être une chaîne de caractères.',
                'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',

                'description.string' => 'La description doit être une chaîne de caractères.',

                'email.required' => 'L\'email est obligatoire.',
                'email.email' => 'L\'email doit être une adresse email valide.',

                'phone_number.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
                'phone_number.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
                'phone_number.regex' => 'Le format du numéro de téléphone est invalide.',

                'logo.image' => 'Le logo doit être une image.',
                'logo.mimes' => 'Le logo doit être au format JPEG, PNG ou JPG.',
                'logo.max' => 'Le logo ne peut pas dépasser 2 Mo.',

                'postal_code.string' => 'Le code postal doit être une chaîne de caractères.',
                'postal_code.max' => 'Le code postal ne peut pas dépasser 10 caractères.',
                'postal_code.regex' => 'Le code postal doit contenir exactement 5 chiffres.',

                'city.string' => 'La ville doit être une chaîne de caractères.',
                'city.max' => 'La ville ne peut pas dépasser 255 caractères.',

                'industry_id.exists' => 'L\'industrie sélectionnée est invalide.',
            ]
        );

        // Création de l'entreprise sans logo
        $company = Company::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'] ?? null,
            'logo_path' => null,
        ]);

        // Upload du logo
        if ($request->hasFile('logo')) {
            $logoPath = $this->uploadFile($request->file('logo'), 'logo_' . $company->id . '_', 'logos_entreprise');
            $company->update(['logo_path' => $logoPath]);
        }

        // Gestion de l'adresse
        if (!empty($validatedData['postal_code']) && !empty($validatedData['city'])) {
            $postalCode = $validatedData['postal_code'];
            $city = ucfirst(strtolower($validatedData['city']));

            $address = Address::firstOrCreate(
                ['postal_code' => $postalCode],
                ['city' => $city]
            );

            $company->addresses()->attach($address->id);
        }

        // Association de l'industrie
        if (!empty($validatedData['industry_id'])) {
            $company->industries()->attach($validatedData['industry_id']);
        }

        return redirect()->route('pilot.company.index')->with('success', 'Entreprise créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        if (!$company) {
            return redirect()->route('company.index')->withErrors(['User' => 'Entreprise non trouvée.']);
        }

        $appliesCount = DB::table('applies')
            ->join('offers', 'applies.offer_id', '=', 'offers.id')
            ->where('offers.company_id', $company->id)
            ->distinct('applies.user_id')
            ->count('applies.user_id');

        return view('company.show', compact('company', 'appliesCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        if (!$company) {
            return back()->withErrors(['User' => 'Entreprise non trouvée']);
        }

        $industries = Industry::all();

        return view('pilot.company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'email' => 'required|email:companies,email,' . $company->id,
                'phone_number' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9]{10,15}$/'],
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'postal_code' => ['nullable', 'string', 'max:10', 'regex:/^\d{5}$/'],
                'city' => ['nullable', 'string', 'max:255'],
                'industry_id' => 'nullable|exists:industries,id',
            ],
            [
                'name.required' => 'Le nom de l\'entreprise est obligatoire.',
                'name.string' => 'Le nom doit être une chaîne de caractères.',
                'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',

                'description.string' => 'La description doit être une chaîne de caractères.',

                'email.required' => 'L\'email est obligatoire.',
                'email.email' => 'L\'email doit être une adresse email valide.',

                'phone_number.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
                'phone_number.max' => 'Le numéro de téléphone ne peut pas dépasser 20 caractères.',
                'phone_number.regex' => 'Le format du numéro de téléphone est invalide.',

                'logo.image' => 'Le logo doit être une image.',
                'logo.mimes' => 'Le logo doit être au format JPEG, PNG, JPG ou GIF.',
                'logo.max' => 'Le logo ne peut pas dépasser 2 Mo.',

                'postal_code.string' => 'Le code postal doit être une chaîne de caractères.',
                'postal_code.max' => 'Le code postal ne peut pas dépasser 10 caractères.',
                'postal_code.regex' => 'Le code postal doit contenir exactement 5 chiffres.',

                'city.string' => 'La ville doit être une chaîne de caractères.',
                'city.max' => 'La ville ne peut pas dépasser 255 caractères.',

                'industry_id.exists' => 'L\'industrie sélectionnée est invalide.',
            ]
        );

        // Gestion du logo
        $logoPath = $company->logo_path;
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($company->logo_path) {
                Storage::disk('public')->delete($company->logo_path);
            }

            $logoPath = $this->uploadFile(
                $request->file('logo'),
                'logo_' . $company->id . '_',
                'logos_entreprise'
            );
        }

        // Mise à jour des informations
        $company->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'] ?? null,
            'logo_path' => $logoPath,
        ]);

        // Mise à jour de l'adresse
        if (!empty($validatedData['postal_code']) && !empty($validatedData['city'])) {
            $postalCode = $validatedData['postal_code'];
            $city = ucfirst(strtolower($validatedData['city']));

            $address = Address::firstOrCreate(
                ['postal_code' => $postalCode],
                ['city' => $city]
            );

            // Détacher les anciennes adresses et attacher la nouvelle (si besoin)
            $company->addresses()->sync([$address->id]);
        }

        // Mise à jour de l'industrie
        if (!empty($validatedData['industry_id'])) {
            $company->industries()->sync([$validatedData['industry_id']]);
        }

        return redirect()->route('pilot.company.index')->with('success', 'Entreprise mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company = null)
    {
        if (!$company) {
            return redirect()->route('pilot.company.index')->withErrors(['User' => 'Entreprise non trouvée.']);
        }
        $company->offers()->each(function ($offer) {
            $offer->applies()->delete();
            $offer->delete();
        });
        $company->delete();

        return redirect()->route('pilot.company.index')->with('success', 'Entreprise supprimée');
    }

    public function rate(Request $request, Company $company)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5'
        ]);

        $company->evaluations()->syncWithoutDetaching([
            auth()->id() => ['rating' => $request->rating]
        ]);

        return redirect()->route('company.show', $company)->with('success', 'Note attribuée');
    }

    /**
     * Upload un fichier avec un nom unique
     */
    private function uploadFile($file, $prefix, $folder)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = $prefix . Str::uuid() . '.' . $extension;
        return $file->storeAs($folder, $filename, 'public');
    }
}
