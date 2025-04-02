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
        $request->validate([
            'skill_name' => 'required|string|max:255|unique:skills,skill_name',
        ]);

        Skill::create([
            'skill_name' => $request->skill_name,
        ]);

        return redirect()->route('skill.create')->with('success', 'Skill créée avec succès.');
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
        // Validation des données
        $validatedData = $request->validate([
            'skill_name' => 'required|string|max:255|unique:skills,skill_name,' . $skill->id . ',id',
        ]);


        // Mise à jour de la promotion
        $skill->update($validatedData);

        // Redirection avec un message de succès
        return redirect()->route('skill.edit',$skill)->with('success', 'Skill mis à jour avec succès');
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
