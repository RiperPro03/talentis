<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Auth::user()->offers()->paginate(8);

        return view('wish-list.index', compact('wishlist'));
    }

    public function store(Offer  $offer)
    {
        $user = Auth::user();

        // Vérifier si l'offre est déjà en favoris
        if ($user->offers()->where('offer_id', $offer->id)->exists()) {
            return redirect()->route('wishlist.index')->with('error', 'Cette offre est déjà dans votre liste de favoris');
        }

        // Ajouter l'offre à la wish-list
        $user->offers()->attach($offer);

        return redirect()->route('wishlist.index');
    }

    public function remove(Offer $offer)
    {
        $user = Auth::user();

        // Vérifier si l'offre est bien dans la wish-list de l'utilisateur
        if (!$user->offers()->where('offer_id', $offer->id)->exists()) {
            return redirect()->route('wishlist.index')->with('errors', 'Offre introuvable dans votre liste de favoris');
        }

        // Supprimer l'offre de la wish-list
        $user->offers()->detach($offer);

        return redirect()->route('wishlist.index');
    }

}
