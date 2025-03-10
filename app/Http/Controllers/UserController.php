<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
//        return view('users.index', compact('users'));
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

        ]);
        User::create([

        ]);

        return redirect()->route('user.index')->with('success', 'Utilisateur créé');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user = null)
    {
        if(!$user) {
            return redirect()->route('user.index')->with('error', 'Utilisateur non trouvé');
        }
//        return view('user.show', compact('user'));
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user = null)
    {
        if(!$user) {
            return redirect()->route('user.index')->with('error', 'Utilisateur non trouvé');
        }
//        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([

        ]);
        $user->update([

        ]);

        return redirect()->route('user.index')->with('success', 'Utilisateur modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user = null)
    {
        if(!$user) {
            return redirect()->route('user.index')->with('error', 'Utilisateur non trouvé');
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Utilisateur supprimé');
    }
}
