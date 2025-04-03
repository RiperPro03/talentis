<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    public function index()
    {
        // Nombre d'offres demandant un certain skill avec jointure sur la table skills
        $skillsOffers = DB::table('contains')
            ->join('skills', 'contains.skill_id', '=', 'skills.id')
            ->select('skills.skill_name as skill_name', DB::raw('COUNT(*) as count'))
            ->groupBy('skills.skill_name')
            ->paginate(5);  // Pagination ajoutée ici

        // Nombre d'offres par secteur avec jointure sur la table sectors
        $sectorOffers = DB::table('offers')
            ->join('sectors', 'offers.sector_id', '=', 'sectors.id')
            ->select('sectors.name as sector_name', DB::raw('COUNT(*) as count'))
            ->groupBy('sectors.name')
            ->paginate(5);  // Pagination ajoutée ici

        // Top 3 des offres les plus présentes dans les wishlists
        $topWishlistedOffers = Offer::select('offers.id', 'offers.title', 'companies.name as company_name', 'offers.base_salary')
            ->join('wishlists', 'wishlists.offer_id', '=', 'offers.id')
            ->join('companies', 'offers.company_id', '=', 'companies.id')  // Jointure sur la table companies
            ->selectRaw('COUNT(wishlists.offer_id) as count')
            ->groupBy('offers.id', 'offers.title', 'companies.name', 'offers.base_salary')
            ->orderByDesc('count')
            ->limit(3)
            ->get();

        // Nombre d'offres de type stage de plus de 3 mois et 6 mois
        $internships3Months = Offer::where('type', 'stage')
            ->whereRaw('TIMESTAMPDIFF(MONTH, start_offer, end_offer) > 3')
            ->count();

        $internships6Months = Offer::where('type', 'stage')
            ->whereRaw('TIMESTAMPDIFF(MONTH, start_offer, end_offer) > 6')
            ->count();

        // Top 3 des offres qui payent le mieux
        $topPayingOffers = Offer::select('offers.id', 'offers.title', 'companies.name as company_name', 'offers.base_salary')
            ->join('companies', 'offers.company_id', '=', 'companies.id')  // Jointure avec la table companies
            ->orderByDesc('offers.base_salary')  // Tri par salaire décroissant
            ->limit(3)
            ->get();

        return view('stats', compact(
            'skillsOffers',
            'sectorOffers',
            'topWishlistedOffers',
            'internships3Months',
            'internships6Months',
            'topPayingOffers'
        ));
    }
}
