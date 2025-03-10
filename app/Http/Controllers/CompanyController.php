<?php

namespace App\Http\Controllers;

use App\Models\Company;
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

        return view('company.index', compact('companies'));
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
//            return redirect()->route('company.index')->with('error', 'Entreprise non trouvée');
            return response()->json(['error' => 'Entreprise non trouvée']);
        }

//        return view('company.show', compact('company'));
        return response()->json($company);
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
//        $request->validate([
//            'company-name' => 'string'
//        ], [
//            'company-name.required' => 'Le nom de l\'entreprise est obligatoire.',
//            'company-name.string' => 'Le nom de l\'entreprise doit être une chaîne de caractères.'
//        ]);
        $name = $request->query('company-name');
        if (!$name) {
            return redirect()->route('company.index')->with('errors', 'Veuillez entrer un nom pour la recherche.');
        }
        $companies = Company::where('name', 'like', '%'.$name.'%')->paginate(8);

        if($companies->total() === 0) {
            return redirect()->route('company.index')->with('errors', 'Aucune entreprise trouvée sous le nom de "'.$name .'"');
        }

        return view('company.index', compact('companies'));
    }
}
