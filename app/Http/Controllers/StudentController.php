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
    public function index(Request $request)
    {
        $query = User::role('student');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('first_name')) {
            $query->where('first_name', 'like', '%' . $request->input('first_name') . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }

        $students = $query->paginate(10);

        return view('pilot.student.index', compact('students'));
    }





    public function create()
    {
        $promotions = Promotion::all('promotion_code', 'id');
        return view('pilot.student.create', compact('promotions'));
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
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gestion de l'adresse
        $address = null;
        if (!empty($validatedData['postal_code']) && !empty($validatedData['city'])) {
            $address = Address::create([
                'postal_code' => $validatedData['postal_code'],
                'city' => $validatedData['city'],
            ]);
        }

        // Gestion de la promotion
        $promotion = null;
        if (!empty($validatedData['promotion'])) {
            $promotion = Promotion::where('promotion_code', $validatedData['promotion'])->first();
        }

        // Gestion de la photo de profil
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $this->uploadFile($request->file('profile_picture'), 'profile_', 'profile_pictures');
        }

        // Création de l'utilisateur
        $student = User::create([
            'name' => $validatedData['name'],
            'first_name' => $validatedData['first_name'],
            'birthdate' => $validatedData['birthdate'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'profile_picture_path' => $profilePicturePath,
            'promotion_id' => $promotion?->id,
        ]);

        if ($address) {
            $student->addresses()->associate($address);
            $student->save();
        }

        $student->assignRole('student');

        return redirect()->route('student.create')->with('success', 'Étudiant créé avec succès.');
    }

    public function edit(User $student)
    {
        $student->load('addresses', 'promotion');
        $address = $student->addresses->first();
        $promotions = Promotion::all('promotion_code', 'id');

        return view('pilot.student.edit', compact('student', 'promotions', 'address'));
    }

    public function update(Request $request, User $student)
    {
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
            'promotion' => 'nullable|exists:promotions,promotion_code',
        ]);

        // Gestion de la photo de profil
        if ($request->hasFile('profile_picture')) {
            if ($student->profile_picture_path) {
                Storage::disk('public')->delete($student->profile_picture_path);
            }
            $path = $this->uploadFile($request->file('profile_picture'), 'profile_' . $student->id, 'profile_pictures');
            $validatedData['profile_picture_path'] = $path;
        }

        // Traitement du mot de passe
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        // Association de l'adresse
        if ($request->filled(['postal_code', 'city'])) {
            $address = Address::create([
                'postal_code' => $request->postal_code,
                'city' => $request->city,
            ]);
            $student->addresses()->associate($address);
        }

        // Mise à jour promotion
        if ($request->filled('promotion')) {
            $promotion = Promotion::where('promotion_code', $request->promotion)->first();
            if ($promotion) {
                $student->promotion_id = $promotion->id;
            }
        }

        $student->update($validatedData);

        return redirect()->route('student.edit', $student)->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->back()->with('success', 'Étudiant retiré avec succès.');
    }

    /**
     * Upload un fichier avec un nom propre
     */
    private function uploadFile($file, $prefix, $folder)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = $prefix . Str::uuid() . '.' . $extension;
        return $file->storeAs($folder, $filename, 'public');
    }

}


