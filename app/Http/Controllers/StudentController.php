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
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'birthdate' => 'required|date',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'postal_code' => ['nullable', 'string', 'max:10', 'regex:/^\d{5}$/'],
                'city' => 'nullable|string|max:255',
                'promotion' => 'nullable|exists:promotions,promotion_code',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'name.required' => 'Le nom est obligatoire.',
                'name.string' => 'Le nom doit être une chaîne de caractères.',
                'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',

                'first_name.required' => 'Le prénom est obligatoire.',
                'first_name.string' => 'Le prénom doit être une chaîne de caractères.',
                'first_name.max' => 'Le prénom ne doit pas dépasser 255 caractères.',

                'birthdate.required' => 'La date de naissance est obligatoire.',
                'birthdate.date' => 'La date de naissance doit être une date valide.',

                'email.required' => 'L\'adresse email est obligatoire.',
                'email.email' => 'L\'adresse email doit être valide.',
                'email.unique' => 'Cette adresse email est déjà utilisée.',

                'password.required' => 'Le mot de passe est obligatoire.',
                'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',

                'postal_code.string' => 'Le code postal doit être une chaîne de caractères.',
                'postal_code.max' => 'Le code postal ne doit pas dépasser 10 caractères.',
                'postal_code.regex' => 'Le code postal doit contenir 5 chiffres.',

                'city.string' => 'La ville doit être une chaîne de caractères.',
                'city.max' => 'La ville ne doit pas dépasser 255 caractères.',

                'promotion.exists' => 'La promotion sélectionnée est invalide.',

                'profile_picture.image' => 'La photo de profil doit être une image.',
                'profile_picture.mimes' => 'Le format de la photo doit être jpeg, png ou jpg.',
                'profile_picture.max' => 'La taille de la photo ne doit pas dépasser 2 Mo.',
            ]
        );

        // Upload de la photo de profil
        $profilePicturePath = $request->hasFile('profile_picture')
            ? $this->uploadFile($request->file('profile_picture'), 'profile_', 'profile_pictures')
            : null;

        // Récupération ou création de l'adresse
        $addressId = null;
        $postalCode = $validatedData['postal_code'] ?? null;
        $city = $validatedData['city'] ?? null;

        if ($postalCode && $city) {
            $formattedCity = ucfirst(strtolower($city));

            $address = Address::firstOrCreate(
                ['postal_code' => $postalCode],
                ['city' => $formattedCity]
            );

            $addressId = $address->id;
        }

        // Récupération de l'ID de la promotion (si fournie)
        $promotionId = $validatedData['promotion']
            ? Promotion::where('promotion_code', $validatedData['promotion'])->value('id')
            : null;

        // Création de l'utilisateur
        $student = User::create([
            'name' => $validatedData['name'],
            'first_name' => $validatedData['first_name'],
            'birthdate' => $validatedData['birthdate'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'profile_picture_path' => $profilePicturePath,
            'promotion_id' => $promotionId,
            'address_id' => $addressId,
        ]);

        $student->assignRole('student');

        return redirect()->route('student.index')->with('success', 'Étudiant créé avec succès.');
    }


    public function edit(User $student)
    {
        $student->load('addresses', 'promotion');
        $promotions = Promotion::all('promotion_code', 'id');

        return view('pilot.student.edit', compact('student', 'promotions'));
    }

    public function update(Request $request, User $student)
    {
        $validatedData = $request->validate(
            [
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'birthdate' => 'required|date',
                'password' => 'nullable|string|min:8|confirmed',
                'email' => 'required|email|max:255|unique:users,email,' . $student->id,
                'postal_code' => [
                    'nullable', 'string', 'max:10', 'regex:/^\d{5}$/',
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
            ],
            [
                'profile_picture.image' => 'La photo de profil doit être une image.',
                'profile_picture.mimes' => 'Le format de la photo doit être jpeg, png, jpg.',
                'profile_picture.max' => 'La taille de la photo ne doit pas dépasser 2 Mo.',

                'name.required' => 'Le nom est obligatoire.',
                'name.string' => 'Le nom doit être une chaîne de caractères.',
                'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',

                'first_name.required' => 'Le prénom est obligatoire.',
                'first_name.string' => 'Le prénom doit être une chaîne de caractères.',
                'first_name.max' => 'Le prénom ne doit pas dépasser 255 caractères.',

                'birthdate.required' => 'La date de naissance est obligatoire.',
                'birthdate.date' => 'La date de naissance doit être une date valide.',

                'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',

                'email.required' => 'L\'adresse email est obligatoire.',
                'email.email' => 'L\'adresse email doit être valide.',
                'email.max' => 'L\'adresse email ne doit pas dépasser 255 caractères.',
                'email.unique' => 'Cette adresse email est déjà utilisée.',

                'postal_code.string' => 'Le code postal doit être une chaîne de caractères.',
                'postal_code.max' => 'Le code postal ne doit pas dépasser 10 caractères.',
                'postal_code.regex' => 'Le code postal doit contenir 5 chiffres.',

                'city.string' => 'La ville doit être une chaîne de caractères.',
                'city.max' => 'La ville ne doit pas dépasser 255 caractères.',

                'promotion.exists' => 'La promotion sélectionnée est invalide.',
            ]
        );

        // Gestion de la photo de profil
        if ($request->hasFile('profile_picture')) {
            // Suppression ancienne photo si existe
            if ($student->profile_picture_path) {
                Storage::disk('public')->delete($student->profile_picture_path);
            }
            $validatedData['profile_picture_path'] = $this->uploadFile(
                $request->file('profile_picture'),
                'profile_' . $student->id,
                'profile_pictures'
            );
        }

        // Gestion du mot de passe
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        // Gestion de l'adresse
        if ($request->filled(['postal_code', 'city'])) {
            $postalCode = $validatedData['postal_code'];
            $city = ucfirst(strtolower($validatedData['city']));

            $address = Address::firstOrCreate(
                ['postal_code' => $postalCode],
                ['city' => $city]
            );

            $student->addresses()->associate($address);
        }

        // Mise à jour de la promotion
        if ($request->filled('promotion')) {
            $promotionId = Promotion::where('promotion_code', $request->promotion)->value('id');
            $student->promotion_id = $promotionId;
        }

        // Mise à jour de l'utilisateur
        $student->update($validatedData);

        return redirect()->route('student.index', $student)->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('student.index')->with('success', 'Étudiant retiré avec succès.');
    }

    /**
     * Upload un fichier avec un nom unique
     */
    private function uploadFile($file, $prefix, $folder)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = $prefix . Str::uuid() . '.' . $extension;
        return $file->storeAs($folder, $filename, 'public');
    }

    public function show(User $student)
    {
        $user = $student;
        if (!($user->hasRole('student'))) {
            return redirect()->route('student.index')->withErrors([
                'User' => 'Cet utilisateur n\'est pas un étudiant.'
            ]);
        }

        // Récupération complète des relations
        $wishlistCount = $user->offers()->count();
        $appliesCount = $user->applies()->count();

        // On ne récupère que les 3 premiers éléments
        $wishlist = $user->offers()
            ->with('companies')
            ->latest('wishlists.created_at')
            ->take(3)
            ->get();

        $applies = $user->applies()
            ->with('companies')
            ->orderByPivot('created_at', 'desc')
            ->take(3)
            ->get();

        return view('pilot.student.show', compact(
            'user',
            'wishlist',
            'applies',
            'wishlistCount',
            'appliesCount'
        ));
    }

}


