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

        // Ajouter un count des étudiants avec rôle student
        $query->withCount(['users as students_count' => function ($q) {
            $q->role('student');
        }]);

        // Récupération des promotions paginées
        $promotions = $query->paginate(10);

        return view('pilot.promotion.index', compact('promotions'));
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
        $validatedData = $request->validate(
            [
                'promotion_code' => 'required|string|max:255|unique:promotions,promotion_code',
            ],
            [
                'promotion_code.required' => 'Le code de promotion est obligatoire.',
                'promotion_code.string' => 'Le code de promotion doit être une chaîne de caractères.',
                'promotion_code.max' => 'Le code de promotion ne doit pas dépasser 255 caractères.',
                'promotion_code.unique' => 'Ce code de promotion existe déjà.',
            ]
        );

        Promotion::create($validatedData);

        return redirect()->route('promotion.index')->with('success', 'Promotion créée avec succès.');
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

        return view('pilot.promotion.edit', compact('promotion',));
    }


    public function update(Request $request, Promotion $promotion)
    {
        // Validation des données avec messages personnalisés
        $validatedData = $request->validate(
            [
                'promotion_code' => 'required|string|max:255|unique:promotions,promotion_code,' . $promotion->id,
            ],
            [
                'promotion_code.required' => 'Le code de promotion est obligatoire.',
                'promotion_code.string' => 'Le code de promotion doit être une chaîne de caractères.',
                'promotion_code.max' => 'Le code de promotion ne doit pas dépasser 255 caractères.',
                'promotion_code.unique' => 'Ce code de promotion existe déjà.',
            ]
        );

        // Mise à jour
        $promotion->update($validatedData);

        return redirect()->route('promotion.index')->with('success', 'Promotion mise à jour avec succès.');
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
