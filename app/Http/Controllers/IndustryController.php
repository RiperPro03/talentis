<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Industry::query();

        // Vérifier si un filtre par nom est appliqué
        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $industries = $query->latest()->paginate(10);

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
        $validatedData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:industries,name',
            ],
        ], [
            'name.required' => 'Le nom de l\'industrie est obligatoire.',
            'name.string' => 'Le nom de l\'industrie doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'name.unique' => 'Cette industrie existe déjà.',
        ]);

        Industry::create($validatedData);

        return redirect()->route('industry.index')
            ->with('success', 'Industrie créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Industry $industry = null)
    {

        if(!$industry) {
            return redirect()->route('industry.index')->withErrors(['User' => 'Industrie non trouvée.']);
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
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:industries,name,' . $industry->id,
            ],
        ], [
            'name.required' => 'Le nom de l\'industrie est obligatoire.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'name.unique' => 'Ce nom d\'industrie existe déjà.',
        ]);

        $industry->update($validatedData);

        return redirect()->route('industry.index')
            ->with('success', 'Industrie mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Industry $industry)
    {
        if (!$industry) {
            return redirect()->route('industry.index')->withErrors(['User' => 'Industrie non trouvée.']);
        }

        $industry->delete(); // Soft Delete

        return redirect()->route('industry.index')->with('success', 'Industrie supprimée avec succès.');
    }
}
