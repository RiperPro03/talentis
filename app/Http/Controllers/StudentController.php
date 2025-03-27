<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::role('student')->get();
        return view('pilot.student.index', compact('students'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user = null)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $student)
    {
        $student->load('addresses', 'promotion'); // Charge aussi la promotion de l'utilisateur
        $address = $student->addresses->first(); // Récupère la première adresse
        $promotions = Promotion::all('promotion_code', 'id'); // Récupère toutes les promotions

        return view('pilot.student.edit', compact('student', 'promotions', 'address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->back()->with('success', 'Étudiant retiré avec succès.');
    }





}
