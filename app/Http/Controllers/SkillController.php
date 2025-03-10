<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::all();
//        return view('skill.index', compact('skills'));
        return response()->json($skills);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        return view('skills.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

        ]);
        Skill::create([

        ]);

        return redirect()->route('skill.index')->with('success', 'Compétence créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill = null)
    {
        if(!$skill){
            return redirect()->route('skill.index')->with('error', 'Compétence non trouvée');
        }
//        return view('skill.show', compact('skill'));
        return response()->json($skill);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill = null)
    {
        if(!$skill){
            return redirect()->route('skill.index')->with('error', 'Compétence non trouvée');
        }
//        return view('skill.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $request->validate([

        ]);
        $skill->update([

        ]);

        return redirect()->route('skill.index')->with('success', 'Compétence modifiée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill = null)
    {
        if (!$skill) {
            return redirect()->route('skill.index')->with('error', 'Compétence non trouvée');
        }
        $skill->delete();
        return redirect()->route('skill.index')->with('success', 'Compétence supprimée');
    }
}
