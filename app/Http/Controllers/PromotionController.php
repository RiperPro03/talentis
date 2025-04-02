<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Promotion::query();

        // Filtrer par code de promotion
        if ($request->filled('promotion_code')) {
            $query->where('promotion_code', 'like', '%' . $request->input('promotion_code') . '%');
        }

        // Récupération des promotions paginées
        $promotions = $query->paginate(10);

        // Retourner la vue avec les résultats
        return view('pilot/promotion.index', compact('promotions'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pilot/promotion.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'promotion_code' => 'required|string|max:255|unique:promotions,promotion_code',
        ]);

        Promotion::create([
            'promotion_code' => $request->promotion_code,
        ]);

        return redirect()->route('promotion.create')->with('success', 'Promotion créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion = null)
    {
        if(!$promotion) {
            return redirect()->route('promotion.index')->withErrors(['User' => 'Promotion non trouvée.']);
        }

//        return view('promotion.show', compact('promotion'));
        return response()->json($promotion);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {

        $promotions = Promotion::all('promotion_code', 'id'); // Récupère toutes les promotions

        return view('pilot.promotion.edit', compact('promotion',));
    }


    public function update(Request $request, Promotion $promotion)
    {
        // Validation des données
        $validatedData = $request->validate([
            'promotion_code' => 'required|string|max:255|unique:promotions,promotion_code,' . $promotion->id,
        ]);

        // Mise à jour de la promotion
        $promotion->update($validatedData);

        // Redirection avec un message de succès
        return redirect()->route('promotion.edit',$promotion)->with('success', 'Promotion mise à jour avec succès');
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion = null)
    {
        if(!$promotion) {
            return redirect()->route('promotion.index')->withErrors(['User' => 'Promotion non trouvée.']);
        }
        $promotion->delete();
        return redirect()->route('promotion.index')->with('success', 'Promotion supprimée');
    }
}
