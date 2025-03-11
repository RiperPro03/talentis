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
//        return view('industries.index', compact('industries'));
        return response()->json($industries);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        return view('industries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

        ]);
        Industry::create([

        ]);;

        return redirect()->route('industries.index')->with('success', 'Industrie créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Industry $industry = null)
    {
        if(!$industry) {
            return redirect()->route('industries.index')->with('error', 'Industrie non trouvée');
        }

//        return view('industries.show', compact('industry'));
        return response()->json($industry);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Industry $industry = null)
    {
        if (!$industry) {
            return redirect()->route('industries.index')->with('error', 'Industrie non trouvée');
        }

//        return view('industries.edit', compact('industry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Industry $industry)
    {
        $request->validate([

        ]);
        $industry->update([

        ]);

        return redirect()->route('industries.index')->with('success', 'Industrie modifiée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Industry $industry = null)
    {
        if (!$industry) {
            return redirect()->route('industries.index')->with('error', 'Industrie non trouvée');
        }
        $industry->delete();
        return redirect()->route('industries.index')->with('success', 'Industrie supprimée');
    }
}
