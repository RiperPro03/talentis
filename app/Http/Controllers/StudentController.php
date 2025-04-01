<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Promotion;
use App\Models\User; // Utilisation du modèle User
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\DB;



class StudentController extends Controller
{
    public function index()
    {
        $students = User::role('student')->get();
        return view('pilot/student.index', compact('students'));
    }
    /**
     * Show the form for editing the specified student.
     */
    public function edit(User $student)
    {
        // Charger les relations nécessaires
        $student->load('addresses', 'promotion'); // Charger les relations 'addresses' et 'promotion'
        $address = $student->addresses->first(); // Récupère la première adresse associée
        $promotions = Promotion::all('promotion_code', 'id'); // Récupère toutes les promotions

        // Retourne la vue d'édition de l'étudiant avec les données nécessaires
        return view('pilot/student.edit', compact('student', 'promotions', 'address'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, User $student)
    {
        // Valider les données de la requête
        $validatedData = $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'password' => 'nullable|string|min:8|confirmed',
            'email' => 'required|email|max:255|unique:users,email,' . $student->id,
            'promotion_id' => 'nullable|exists:promotions,id',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
        ]);

        // Traiter la photo de profil si elle est présente
        if ($request->hasFile('profile_picture')) {
            // Supprimer l'ancienne photo si elle existe
            if ($student->profile_picture_path) {
                Storage::delete($student->profile_picture_path);
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
            // Associer l'adresse à l'utilisateur (étudiant)
            $student->addresses()->associate($address);
        }

        // Mettre à jour les informations de l'étudiant
        $student->update($validatedData);
        if ($request->has('promotion')) {
            $promotionCode = $request->promotion; // L'ID de la promotion choisie
            $promotion = Promotion::where('promotion_code', $promotionCode)->first(); // Récupère la promotion par son code

            if ($promotion) {
                $student->promotion_id = $promotion->id; // Met à jour la promotion_id de l'étudiant
                $student->save(); // Sauvegarde les changements
            }
        }

        // Rediriger vers la page d'édition avec un message de succès
        return redirect()->route('student.edit', $student)->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function create()
    {

        $promotions = Promotion::all(); // Récupère toutes les promotions pour l'affichage dans le formulaire
        return view('pilot/student.create', compact('promotions'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:255',
            'promotion' => 'nullable|exists:promotions,promotion_code',
        ]);

        // Vérifier si l'adresse existe déjà
        $address = DB::table('addresses')->where([
            'postal_code' => $validatedData['postal_code'],
            'city' => $validatedData['city'],
        ])->first();

        // Si l'adresse n'existe pas, la créer
        if (!$address) {
            $addressId = DB::table('addresses')->insertGetId([
                'postal_code' => $validatedData['postal_code'],
                'city' => $validatedData['city'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $addressId = $address->id;
        }

        // Récupérer l'ID de la promotion à partir du promotion_code
        $promotionId = null;
        if (!empty($validatedData['promotion'])) {
            $promotion = DB::table('promotions')->where('promotion_code', $validatedData['promotion'])->first();
            if ($promotion) {
                $promotionId = $promotion->id;
            }
        }

        // Créer l'utilisateur en lui attribuant l'adresse et l'ID de la promotion
        $userId = DB::table('users')->insertGetId([
            'name' => $validatedData['name'],
            'first_name' => $validatedData['first_name'],
            'birthdate' => $validatedData['birthdate'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'address_id' => $addressId,
            'promotion_id' => $promotionId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Récupérer l'utilisateur
        $user = User::find($userId);

        // Assigner le rôle 'student'
        $user->assignRole('student');

        return redirect()->route('student.create')->with('success', 'Utilisateur créé avec succès.');
    }

}


