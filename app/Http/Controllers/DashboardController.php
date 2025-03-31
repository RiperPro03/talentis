<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $pilotCount = User::role('pilot')->count();
        $studentCount = User::role('student')->count();
        $offerCount = Offer::count();
        $companyCount = Company::count();

        // Nombre de jours distincts
        $daysCount = Offer::selectRaw('DATE(created_at) as day')
            ->distinct()
            ->count();

        // Calcul de la moyenne
        $averageOffersPerDay = $daysCount > 0 ? round($offerCount / $daysCount, 2) : 0;

        return view('dashboard.index', [
            'pilotCount' => $pilotCount,
            'studentCount' => $studentCount,
            'offerCount' => $offerCount,
            'companyCount' => $companyCount,
            'averageOffersPerDay' => $averageOffersPerDay,
        ]);
    }
}
