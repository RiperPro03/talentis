<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Promotion;
use App\Models\User; // Utilisation du modèle User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

        // Vérifier si l'utilisateur a une adresse, sinon mettre à null
        $address = $student->addresses && $student->addresses->isNotEmpty() ? $student->addresses->first() : null;

        $promotions = Promotion::all('promotion_code', 'id'); // Récupère toutes les promotions

        // Retourne la vue d'édition de l'étudiant avec les données nécessaires
        return view('pilot/student.edit', compact('student', 'promotions', 'address'));
    }


    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, User $student)
    {
        // Validation
        $validatedData = $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'password' => 'nullable|string|min:8|confirmed',
            'email' => 'required|email|max:255|unique:users,email,' . $student->id,
            'promotion_id' => 'nullable|exists:promotions,id',
            'postal_code' => [
                'nullable', 'string', 'max:10',
                function ($attribute, $value, $fail) {
                    if ($value === 'Non assigné') {
                        $fail('Veuillez assigner une valeur au code postal.');
                    }
                },
            ],
            'city' => [
                'nullable', 'string', 'max:255',
                function ($attribute, $value, $fail) {
                    if ($value === 'Non assigné') {
                        $fail('Veuillez assigner une valeur à la ville.');
                    }
                },
            ],
        ]);

        // Gestion de la photo de profil
        if ($request->hasFile('profile_picture')) {
            if ($student->profile_picture_path) {
                Storage::disk('public')->delete($student->profile_picture_path);
            }

            $path = $this->uploadFile($request->file('profile_picture'), 'profile_' . $student->id, 'logos');
            $validatedData['profile_picture_path'] = $path;
        }

        // Traitement du mot de passe
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        // Association de l'adresse si présente
        if ($request->filled(['postal_code', 'city'])) {
            $address = Address::firstOrCreate(
                ['postal_code' => $request->postal_code, 'city' => $request->city]
            );
            $student->addresses()->associate($address);
        }

        // Mise à jour des infos de l'étudiant
        $student->update($validatedData);

        // Mise à jour de la promotion par code si fournie
        if ($request->filled('promotion')) {
            $promotion = Promotion::where('promotion_code', $request->promotion)->first();
            if ($promotion) {
                $student->promotion_id = $promotion->id;
                $student->save();
            }
        }

        return redirect()->route('student.edit', $student)->with('success', 'Étudiant mis à jour avec succès.');
    }

    /**
     * Upload un fichier avec un nom propre
     */
    private function uploadFile($file, $prefix, $folder)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = $prefix . '_' . Str::uuid() . '.' . $extension;
        return $file->storeAs($folder, $filename, 'public');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Utilisateur retiré avec succès.');
    }

}


