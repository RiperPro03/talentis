<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
