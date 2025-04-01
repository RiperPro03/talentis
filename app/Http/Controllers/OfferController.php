<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Company;
use App\Models\Industry;
use App\Models\Offer;
use App\Models\Sector;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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
            return redirect()->route('offers.index', ['page' => $offers->lastPage()]);
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
//        return view('offers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([

        ]);

        // TODO : Faire la vérif que Type est bien un de ces input ['CDI', 'CDD', 'Stage', 'Alternance']
        // TODO : Pour l'input Type : Faire un select avec les options ['CDI', 'CDD', 'Stage', 'Alternance']

        Offer::create([

        ]);

        return redirect()->route('offer.index')->with('success', 'Offre créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        if(!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offre non trouvée');
        }

        return view('offer.show', compact('offer'));
        // return response()->json($offer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer = null)
    {
        if(!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offre non trouvée');
        }

//        return view('offer.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        request()->validate([

        ]);
        $offer->update([

        ]);

        return redirect()->route('offer.index')->with('success', 'Offre modifiée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer = null)
    {
        if(!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offre non trouvée');
        }
        $offer->delete();
        return redirect()->route('offer.index')->with('success', 'Offre supprimée');
    }

}
