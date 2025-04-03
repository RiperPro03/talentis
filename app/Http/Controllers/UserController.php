<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use Storage;

class UserController extends Controller
{
    public function profil()
    {
        $user = auth()->user();

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

        return view('profile.show', compact(
            'user',
            'wishlist',
            'applies',
            'wishlistCount',
            'appliesCount'
        ));
    }
}
