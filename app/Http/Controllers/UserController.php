<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use Storage;

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
    public function edit(User $user)
    {
        $user->load('addresses', 'promotion'); // Charge aussi la promotion de l'utilisateur
        $address = $user->addresses->first(); // Récupère la première adresse
        $promotions = Promotion::all('promotion_code', 'id'); // Récupère toutes les promotions

        return view('pilot.student.edit', compact('user', 'promotions', 'address'));
    }


    public function update(Request $request, User $user)
    {
        // Valider les données de la requête
        $validatedData = $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'password' => 'nullable|string|min:8|confirmed',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'promotion_id' => 'nullable|exists:promotions,id',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
        ]);

        // Traiter la photo de profil si elle est présente
        if ($request->hasFile('profile_picture')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->profile_picture_path) {
                Storage::delete($user->profile_picture_path);
            }
            // Enregistrer la nouvelle photo
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validatedData['profile_picture_path'] = $path;
        }

        // Traiter le mot de passe si un nouveau mot de passe est fourni
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->password);
        } else {
            unset($validatedData['password']);
        }

        // Vérifier si les champs postal_code et city sont remplis
        if ($request->filled('postal_code') && $request->filled('city')) {
            // Vérifier si une adresse avec cette combinaison existe déjà
            $address = Address::firstOrCreate(
                ['postal_code' => $request->postal_code, 'city' => $request->city],
                ['postal_code' => $request->postal_code, 'city' => $request->city]
            );
            // Associer l'adresse à l'utilisateur en utilisant la méthode 'addresses'
            $user->addresses()->associate($address);
        }

        // Mettre à jour les informations de l'utilisateur
        $user->update($validatedData);
        if ($request->has('promotion')) {
            $promotionCode = $request->promotion; // L'ID de la promotion choisie
            $promotion = Promotion::where('promotion_code', $promotionCode)->first(); // Récupère la promotion par son code

            if ($promotion) {
                $user->promotion_id = $promotion->id; // Met à jour la promotion_id de l'utilisateur
                $user->save(); // Sauvegarde les changements
            }
        }


        // Rediriger vers la page d'édition avec un message de succès
        return redirect()->route('users.edit', $user)->with('success', 'Utilisateur mis à jour avec succès.');
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
