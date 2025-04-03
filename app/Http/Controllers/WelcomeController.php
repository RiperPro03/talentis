<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Offer;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $locations = Address::all('city');
        $offers = Offer::latest()->limit(7)->get();
        return view('welcome', compact('offers','locations'));
    }
}
