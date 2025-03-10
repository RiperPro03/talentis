<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
//        return view('company.index', compact('companies'));
        return response()->json($companies);
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
    public function show(Company $company = null)
    {
        if(!$company) {
            return redirect()->route('company.index')->with('error', 'Entreprise non trouvée');
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
            return redirect()->route('company.index')->with('error', 'Entreprise non trouvée');
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
            return redirect()->route('company.index')->with('error', 'Entreprise non trouvée');
        }
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Entreprise supprimée');
    }
}
