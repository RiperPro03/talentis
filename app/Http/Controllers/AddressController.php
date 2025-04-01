<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Show the form for creating a new address.
     */

    public function index()
    {
        $addresses = Address::all();
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
        $request->validate([
            'postal_code' => 'required|string|max:20|unique:addresses',
            'city' => 'required|string|max:255',
        ]);

        Address::create($request->only(['postal_code', 'city']));

        return redirect()->route('address.create')->with('success', 'Address created successfully.');
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
        $request->validate([
            'postal_code' => 'required|string|max:20|unique:addresses,postal_code,' . $address->id,
            'city' => 'required|string|max:255',
        ]);

        $address->update($request->only(['postal_code', 'city']));

        return redirect()->route('address.edit',$address)->with('success', 'Address updated successfully.');
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
