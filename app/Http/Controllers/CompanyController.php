<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Http\Request;
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
//        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

        ]);
        Company::create([

        ]);

        return redirect()->route('company.index')->with('success', 'Entreprise créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::find($id);
        if(!$company) {
            return redirect()->route('company.index')->with('error', 'Entreprise non trouvée');

        }

        return view('company.show', compact('company'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company = null)
    {
        if(!$company) {
            return redirect()->route('company.index')->with('errors', 'Entreprise non trouvée');
        }

//        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([

        ]);
        $company->update([

        ]);

        return redirect()->route('company.index')->with('success', 'Entreprise mise à jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company = null)
    {
        if(!$company) {
            return redirect()->route('company.index')->with('errors', 'Entreprise non trouvée');
        }
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Entreprise supprimée');
    }

    public function search(Request $request)
    {
        $q_name = $request->query('company-name');
        $q_industries = $request->query('industry', []);
        $q_locations = $request->query('location', []);

        $query = Company::query();

        // Filtrer par nom d'entreprise
        if (!empty($q_name)) {
            $query->where('name', 'like', '%' . $q_name . '%');
        }

        // Filtrer par plusieurs secteurs d'activité
        if (!empty($q_industries)) {
            $query->whereHas('industries', function ($query) use ($q_industries) {
                $query->whereIn('name', $q_industries);
            });
        }

        // Filtrer par plusieurs localisations
        if (!empty($q_locations)) {
            $query->whereHas('addresses', function ($query) use ($q_locations) {
                $query->whereIn('city', $q_locations);
            });
        }

        // Récupérer les entreprises avec pagination
        $companies = $query->paginate(8);

        // Récupérer les valeurs pour le formulaire
        $industries = Industry::all('name');
        $locations = Address::all('city');

        return view('company.index', compact('companies', 'industries', 'locations'));
    }

    public function getLastOffers($id)
    {
        $company = Company::with(['offers' => function ($query) {
            $query->latest()->take(3);
        }])->findOrFail($id);

        return view('company.show', compact('company'));
    }
    public function getSector($id)
    {
        $company = Company::with('sector')->find($id);}

}
