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

        return redirect()->route('sector.index')->with('success', 'Secteur créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion = null)
    {
        if(!$promotion) {
            return redirect()->route('sector.index')->with('error', 'Secteur non trouvée');
        }

//        return view('promotion.show', compact('promotion'));
        return response()->json($promotion);
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
            'name' => 'required|string|max:255|unique' . $sector->id,
        ]);

        // Mise à jour de la promotion
        $sector->update($validatedData);

        // Redirection avec un message de succès
        return redirect()->route('sector.edit',$sector)->with('success', 'Promotion mise à jour avec succès');
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
            return redirect()->route('sector.index')->with('error', 'Secteur non trouvée');
        }
        $promotion->delete();
        return redirect()->route('sector.index')->with('success', 'Secteur supprimée');
    }
}
