<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sector::query();

        // Filtrer par nom si une recherche est effectuée
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Récupération des secteurs paginés
        $sectors = $query->paginate(10);

        // Retourner la vue avec les résultats
        return view('pilot/sector.index', compact('sectors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pilot/sector.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255|unique:sectors,name',
            ],
            [
                'name.required' => 'Le nom du secteur est obligatoire.',
                'name.string' => 'Le nom du secteur doit être une chaîne de caractères.',
                'name.max' => 'Le nom du secteur ne doit pas dépasser 255 caractères.',
                'name.unique' => 'Ce secteur existe déjà.',
            ]
        );

        Sector::create($validatedData);

        return redirect()->route('sector.create')->with('success', 'Secteur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sector $sector = null)
    {
        if(!$sector) {
            return redirect()->route('sector.index')->withErrors(['User' => 'Secteur non trouvée.']);
        }

//        return view('promotion.show', compact('promotion'));
        return response()->json($sector);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sector $sector)
    {
        return view('pilot.sector.edit', compact('sector',));
    }


    public function update(Request $request, Sector $sector)
    {
        // Validation avec messages personnalisés
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255|unique:sectors,name,' . $sector->id,
            ],
            [
                'name.required' => 'Le nom du secteur est obligatoire.',
                'name.string' => 'Le nom du secteur doit être une chaîne de caractères.',
                'name.max' => 'Le nom du secteur ne doit pas dépasser 255 caractères.',
                'name.unique' => 'Ce secteur existe déjà.',
            ]
        );

        // Mise à jour
        $sector->update($validatedData);

        // Redirection avec succès
        return redirect()->route('sector.index')->with('success', 'Secteur mis à jour avec succès.');
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
            return redirect()->route('sector.index')->withErrors(['User' => 'Secteur non trouvée.']);
        }
        $promotion->delete();
        return redirect()->route('sector.index')->with('success', 'Secteur supprimée');
    }
}
