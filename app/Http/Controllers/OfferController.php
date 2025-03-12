<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::paginate(8);

        if (Route::currentRouteName() === 'admin.offer.index') {
            return view('admin.offer.show', compact('offers'));
        }

        if (request()->has('page') && request()->page > $offers->lastPage()) {
            return redirect()->route('company.index', ['page' => $offers->lastPage()]);
        }

        return view('offer.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.offer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([

        ]);
        Offer::create([

        ]);

        return redirect()->route('offer.index')->with('success', 'Offre créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer )
    {

        if (Route::currentRouteName() === 'admin.offer.index') {
            return view('admin.offer.show', compact('offers'));
        }

        if(!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offre non trouvée');
        }

        return view('admin.offer.show', compact('offers'));
        return response()->json($offer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        if(!$offer) {
            return redirect()->route('offer.index')->with('error', 'Offre non trouvée');
        }

        return view('offer.edit', compact('offer'));
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
