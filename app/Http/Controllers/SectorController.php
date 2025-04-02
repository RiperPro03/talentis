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
    public function index()
    {
        $sectors = Sector::all();
        return view('pilot.sector.index', compact('sectors'));
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
        $request->validate([
            'name' => 'required|string|max:255|unique:sectors,name',
        ]);

        Sector::create([
            'name' => $request->name,
        ]);

        return redirect()->route('sector.create')->with('success', 'Secteur créée avec succès.');
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
        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:sectors,name,' . $sector->id,
        ]);

        // Mise à jour du secteur
        $sector->update($validatedData);

        // Redirection avec un message de succès
        return redirect()->route('sector.edit', $sector)->with('success', 'Secteur mis à jour avec succès');
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
