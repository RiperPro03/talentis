<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $offers = Offer::latest()->limit(7)->get();
        return view('welcome', compact('offers'));
    }
}
