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
            'phone_number' => 'nullable|string|max:20|regex:/^\+?[0-9]{10,15}$/',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $logoPath = $file->storeAs('logos', $filename, 'public');
        }

        Company::create([
            'name' => $request->name,
            'description' => $request->description,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'logo_path' => $logoPath,
        ]);

        return redirect()->route('pilot.company.index')->with('success', 'Entreprise créée avec succès.');
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
            'phone_number' => 'nullable|string|max:20|regex:/^\+?[0-9]{10,15}$/',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = $company->logo_path;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'logo_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $logoPath = $file->storeAs('logos', $filename, 'public');
        }

        $company->update([
            'name' => $request->name,
            'description' => $request->description,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'logo_path' => $logoPath,
        ]);

        return redirect()->route('pilot.company.index')->with('success', 'Entreprise mise à jour avec succès.');
    }
}
