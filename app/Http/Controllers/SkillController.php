<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Skill::query();

        if ($request->has('search')) {
            $query->where('skill_name', 'like', '%' . $request->search . '%');
        }

        $skills = $query->paginate(10);

        return view('pilot/skill.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pilot/skill.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'skill_name' => 'required|string|max:255|unique:skills,skill_name',
            ],
            [
                'skill_name.required' => 'Le nom de la compétence est obligatoire.',
                'skill_name.string' => 'Le nom de la compétence doit être une chaîne de caractères.',
                'skill_name.max' => 'Le nom de la compétence ne doit pas dépasser 255 caractères.',
                'skill_name.unique' => 'Cette compétence existe déjà.',
            ]
        );

        Skill::create($validatedData);

        return redirect()->route('skill.create')->with('success', 'Compétence créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill = null)
    {
        if(!$skill){
            return redirect()->route('skill.index')->withErrors(['User' => 'Compétence non trouvée.']);
        }
//        return view('skill.show', compact('skill'));
        return response()->json($skill);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        return view('pilot.skill.edit', compact('skill',));
    }


    public function update(Request $request, Skill $skill)
    {
        // Validation avec messages personnalisés
        $validatedData = $request->validate(
            [
                'skill_name' => 'required|string|max:255|unique:skills,skill_name,' . $skill->id,
            ],
            [
                'skill_name.required' => 'Le nom de la compétence est obligatoire.',
                'skill_name.string' => 'Le nom de la compétence doit être une chaîne de caractères.',
                'skill_name.max' => 'Le nom de la compétence ne doit pas dépasser 255 caractères.',
                'skill_name.unique' => 'Cette compétence existe déjà.',
            ]
        );

        // Mise à jour
        $skill->update($validatedData);

        // Redirection avec succès
        return redirect()->route('skill.index')->with('success', 'Compétence mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill = null)
    {
        if (!$skill) {
            return redirect()->route('skill.index')->withErrors(['User' => 'Compétence non trouvée.']);
        }
        $skill->delete();
        return redirect()->route('skill.index')->with('success', 'Compétence supprimée');
    }
}
