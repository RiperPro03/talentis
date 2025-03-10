<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addressies = Address::all();
//        return view('address.index', compact('address'));
        return response()->json($addressies);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        return view('address.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

        ]);
        Address::create([

        ]);

        return redirect()->route('address.index')->with('success', 'Localisation créée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address = null)
    {
        if(!$address) {
            return redirect()->route('address.index')->with('error', 'Localisation non trouvée');
        }
//        return view('address.show', compact('address'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address = null)
    {
        if(!$address) {
            return redirect()->route('address.index')->with('error', 'Localisation non trouvée');
        }
//        return view('address.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $address)
    {
        $request->validate([

        ]);
        $address->update([

        ]);

        return redirect()->route('address.index')->with('success', 'Localisation mise à jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address = null)
    {
        if (!$address) {
            return redirect()->route('address.index')->with('error', 'Localisation non trouvée');
        }
        $address->delete();
        return redirect()->route('address.index')->with('success', 'Localisation supprimée');
    }
}
