<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $companies = Company::paginate(8);
            return view('pilot.company.index', compact('companies'));
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
        $companies = Company::all();
        return view('pilot.company.create', compact('companies'));
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

        $company = Company::create([
            'name' => $request->name,
            'description' => $request->description,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'logo_path' => null,
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = 'logo_' . $company->id . '_' . Str::uuid() . '.' . $extension;
            $logoPath = $file->storeAs('logos_entreprise', $filename, 'public');
        }

        $company->update([
            'logo_path' => $logoPath,
        ]);

        return redirect()->route('pilot.company.index')->with('success', 'Entreprise créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        if (!$company) {
            //            return redirect()->route('company.index')->with('error', 'Entreprise non trouvée');
            return response()->json(['error' => 'Entreprise non trouvée']);
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
            return back()->withErrors(['Pilot' => 'Entreprise non trouvée']);
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
            'phone_number' => 'nullable|string|max:20|regex:/^\+?[0-9]{10,15}$/',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = $company->logo_path;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = 'logo_' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            $logoPath = $file->storeAs('logos_entreprise', $filename, 'public');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company = null)
    {
        if (!$company) {
            return redirect()->route('company.index')->with('errors', 'Entreprise non trouvée');
        }
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Entreprise supprimée');
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
}
