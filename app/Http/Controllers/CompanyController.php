<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::paginate(8);

        if (Route::currentRouteName() === 'admin.company.index') {
            return view('admin.company.index', compact('companies'));
        }

        if (Route::currentRouteName() === 'pilot.company.index') {
            return view('pilot.company.index', compact('companies'));
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
        return view('pilot.company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'email' => 'required|email|unique:companies,email',
        'phone_number' => 'nullable|string|max:20',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation du logo
    ]);

    $logoPath = null;
    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $filename = 'logo_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $logoPath = $file->storeAs('logos', $filename, 'public'); // Stockage dans "storage/app/public/logos"
    }

    Company::create([
        'name' => $request->name,
        'description' => $request->description,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'logo_path' => $logoPath, // Sauvegarde du chemin du logo
    ]);

    return redirect()->route('company.index')->with('success', 'Entreprise créée avec succès.');
}


    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        if(!$company) {
            return redirect()->route('company.index')->with('error', 'Entreprise non trouvée');
            return response()->json(['error' => 'Entreprise non trouvée']);
        }

        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        if(!$company) {
            return redirect()->route('company.index')->with('errors', 'Entreprise non trouvée');
        }

        return view('pilot.company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'email' => 'required|email|unique:companies,email,' . $company->id,
        'phone_number' => 'nullable|string|max:20',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation du logo
    ]);

    $logoPath = $company->logo_path;
    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $filename = 'logo_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $logoPath = $file->storeAs('logos', $filename, 'public'); // Stockage dans "storage/app/public/logos"
    }

    $company->update([
        'name' => $request->name,
        'description' => $request->description,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'logo_path' => $logoPath, // Mise à jour du logo si modifié
    ]);

    return redirect()->route('company.index')->with('success', 'Entreprise mise à jour avec succès.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        if(!$company) {
            return redirect()->route('company.index')->with('errors', 'Entreprise non trouvée');
        }
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Entreprise supprimée');
    }

    public function search(Request $request)
    {
        // Récupération des filtres depuis la requête
        $filters = [
            'company'      => (array) $request->query('company', []),
            'industry'     => (array) $request->query('industry', []),
            'location'     => (array) $request->query('location', [])
        ];

        // Début de la requête sur Company
        $query = Company::query();

        // Filtrer par plusieurs entreprises spécifiques
        if (!empty($filters['company'])) {
            $query->whereIn('name', $filters['company']);
        }

        // Filtrage dynamique sur relations (industries et addresses)
        $relations = [
            'industries' => 'name',
            'addresses'  => 'city'
        ];

        foreach ($relations as $relation => $column) {
            if (!empty($filters[$relation])) {
                $query->whereHas($relation, fn($q) => $q->whereIn($column, $filters[$relation]));
            }
        }

        // Récupération des entreprises avec pagination
        $companies = $query->paginate(8);

        // Récupération des valeurs pour les filtres
        $industries = Industry::all(['name']);
        $locations = Address::all(['city']);

        return view('company.index', compact('companies', 'industries', 'locations'));
    }
}
