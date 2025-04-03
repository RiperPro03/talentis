<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class AddressController extends Controller
{
    /**
     * Show the form for creating a new address.
     */




    public function index(Request $request)
    {
        // Récupérer les valeurs de recherche
        $city = $request->query('city');
        $postalCode = $request->query('postal_code');

        $addresses = Address::when($city, function ($query) use ($city) {
            $query->where('city', 'like', "%$city%");
        })
            ->when($postalCode, function ($query) use ($postalCode) {
                $query->where('postal_code', 'like', "%$postalCode%");
            })
            ->paginate(10);

        return view('pilot.address.index', compact('addresses'));
    }





    public function create()
    {
        return view('pilot/address.create');
    }

    /**
     * Store a newly created address in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'postal_code' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d{5}$/',
                'unique:addresses,postal_code',
            ],
            'city' => 'required|string|max:255',
        ], [
            'postal_code.required' => 'Le code postal est obligatoire.',
            'postal_code.string' => 'Le code postal doit être une chaîne de caractères.',
            'postal_code.max' => 'Le code postal ne doit pas dépasser 20 caractères.',
            'postal_code.regex' => 'Le code postal doit être un code postal français valide (5 chiffres).',
            'postal_code.unique' => 'Ce code postal existe déjà.',
            'city.required' => 'La ville est obligatoire.',
            'city.string' => 'Le nom de la ville doit être une chaîne de caractères.',
            'city.max' => 'Le nom de la ville ne doit pas dépasser 255 caractères.',
        ]);

        Address::create($validatedData);

        return redirect()->route('address.index')->with('success', 'Adresse créée avec succès.');
    }

    /**
     * Show the form for editing the specified address.
     */
    public function edit(Address $address)
    {
        return view('pilot/address.edit', compact('address'));
    }

    /**
     * Update the specified address in storage.
     */
    public function update(Request $request, Address $address)
    {
        $validatedData = $request->validate([
            'postal_code' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d{5}$/',
                'unique:addresses,postal_code,' . $address->id,
            ],
            'city' => 'required|string|max:255',
        ], [
            'postal_code.required' => 'Le code postal est obligatoire.',
            'postal_code.string' => 'Le code postal doit être une chaîne de caractères.',
            'postal_code.max' => 'Le code postal ne doit pas dépasser 20 caractères.',
            'postal_code.regex' => 'Le code postal doit être un code postal français valide (5 chiffres).',
            'postal_code.unique' => 'Ce code postal est déjà utilisé.',
            'city.required' => 'La ville est obligatoire.',
            'city.string' => 'Le nom de la ville doit être une chaîne de caractères.',
            'city.max' => 'Le nom de la ville ne doit pas dépasser 255 caractères.',
        ]);

        $address->update($validatedData);

        return redirect()->route('address.index')->with('success', 'Adresse mise à jour avec succès.');
    }

    /**
     * Remove the specified address from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return redirect()->route('address.index')->with('success', 'Address deleted successfully.');
    }
}
