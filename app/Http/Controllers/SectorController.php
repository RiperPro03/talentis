<?php

namespace App\Http\Controllers;

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
//        return view('sector.index', compact('sectors'));
        return response()->json($sectors);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        return view('sectors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

        ]);
        Sector::create([

        ]);

        return redirect()->route('sector.index')->with('success', 'Secteur créé');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sector $sector = null)
    {
        if(!$sector) {
            return redirect()->route('sector.index')->with('error', 'Secteur non trouvé');
        }
//        return view('sector.show', compact('sector'));
        return response()->json($sector);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sector $sector = null)
    {
        if(!$sector) {
            return redirect()->route('sector.index')->with('error', 'Secteur non trouvé');
        }
//        return view('sector.edit', compact('sector'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sector $sector)
    {
        $request->validate([

        ]);
        $sector->update([

        ]);
        return redirect()->route('sector.index')->with('success', 'Secteur modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector = null)
    {
        if(!$sector) {
            return redirect()->route('sector.index')->with('error', 'Secteur non trouvé');
        }
        $sector->delete();
        return redirect()->route('sector.index')->with('success', 'Secteur supprimé');
    }
}
