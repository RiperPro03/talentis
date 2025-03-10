<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::all();
//        return view('promotion.index', compact('promotions'));
        return response()->json($promotions);
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
        $request->validate([

        ]);
        Promotion::create([

        ]);

        return redirect()->route('promotion.index')->with('success', 'Promotion créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion = null)
    {
        if(!$promotion) {
            return redirect()->route('promotion.index')->with('error', 'Promotion non trouvée');
        }

//        return view('promotion.show', compact('promotion'));
        return response()->json($promotion);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion = null)
    {
        if(!$promotion) {
            return redirect()->route('promotion.index')->with('error', 'Promotion non trouvée');
        }

//        return view('promotion.edit', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([

        ]);
        $promotion->update([

        ]);

        return redirect()->route('promotion.index')->with('success', 'Promotion modifiée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion = null)
    {
        if(!$promotion) {
            return redirect()->route('promotion.index')->with('error', 'Promotion non trouvée');
        }
        $promotion->delete();
        return redirect()->route('promotion.index')->with('success', 'Promotion supprimée');
    }
}
