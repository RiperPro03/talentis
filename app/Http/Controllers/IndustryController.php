<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $industries = Industry::all();
        return view('pilot/industry.index', compact('industries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pilot/industry.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:industries,name',
        ]);

        Industry::create([
            'name' => $request->name,
        ]);

        return redirect()->route('industry.create')->with('success', 'Industrie créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Industry $industry = null)
    {

        if(!$industry) {
            return redirect()->route('industry.index')->with('error', 'Industrie non trouvée');
        }

//        return view('promotion.show', compact('promotion'));
        return response()->json($industry);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Industry $industry = null)
    {


        return view('pilot/industry.edit', compact('industry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Industry $industry)
    {
        $validatedData = $request->validate([
            'name' => 'max:255|unique:industries,name,' . $industry->id

        ]);


        $industry->update($validatedData);

        // Redirection avec un message de succès
        return redirect()->route('industry.edit',$industry)->with('success', 'Industry mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Industry $industry)
    {
        if (!$industry) {
            return redirect()->route('industry.index')->with('error', 'Industrie non trouvée');
        }

        $industry->delete(); // Soft Delete

        return redirect()->route('industry.index')->with('success', 'Industrie supprimée avec succès.');
    }
}
