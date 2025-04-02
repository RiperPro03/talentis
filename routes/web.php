<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ApplicationController;
use App\Models\Offer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Route accessible par tout le monde
Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/legal-mentions', function () {
    return view('legal-mentions');
})->name('legal.mentions');

// Route pour les utilisateurs non authentifiés
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware(['auth'])->group(function () {
    // Déconnexion
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    //Company
    Route::get('company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('company/{company}', [CompanyController::class, 'show'])->name('company.show');

    //Offer
    Route::get('offer', [OfferController::class, 'index'])->name('offer.index');
    Route::get('offer/{offer}', [OfferController::class, 'show'])->name('offer.show');

    //Profile
    Route::get('my/profil', [UserController::class, 'profil'])->name('profil.show');
});

Route::middleware(['auth', 'can:access_apply'])->group(function () {
    //Candidature
    Route::get('/offer/{offer}/apply', [ApplicationController::class, 'create'])->name('apply.create');
    Route::post('/offer/{offer}/apply', [ApplicationController::class, 'store'])->name('apply.store');
    Route::get('my/applications', [ApplicationController::class, 'index'])->name('apply.index');
    Route::delete('/offer/{offer}/apply', [ApplicationController::class, 'destroy'])->name('apply.remove');
});

Route::middleware(['auth', 'can:access_rate'])->group(function () {
    Route::post('company/{company}/rate', [CompanyController::class, 'rate'])->name('company.rate');
});

Route::middleware(['auth', 'can:access_wishlist'])->group(function () {
    //Wishlist
    Route::get('my/wish-list', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('my/wish-list/{offer}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('my/wish-list/{offer}', [WishListController::class, 'remove'])->name('wishlist.remove');
});


// Routes Pilot ----------------------------------------------------------------
Route::middleware(['auth', 'can:access_dashboard'])->group(function () {
    //Pilot dashboard
    Route::get('pilot/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::middleware(['auth', 'can:manage_students'])->group(function () {
    Route::resource('pilot/student', StudentController::class);

    Route::get('pilot/apply', [ApplicationController::class, 'index'])->name('pilot.apply.index');
    Route::delete('pilot/apply/{offer}/{user}', [ApplicationController::class, 'destroy'])->name('pilot.apply.remove');

    Route::resource('pilot/promotion', PromotionController::class);
    Route::resource('pilot/address', AddressController::class);
});

Route::middleware(['auth', 'can:manage_company'])->group(function () {
    // Industry
    Route::resource('pilot/industry', IndustryController::class);

    // Company
    Route::resource('pilot/company', CompanyController::class)->names([
        'index' => 'pilot.company.index',
        'show' => 'pilot.company.show',
        'create' => 'pilot.company.create',
        'edit' => 'pilot.company.edit',
        'store' => 'pilot.company.store',
        'update' => 'pilot.company.update',
        'destroy' => 'pilot.company.destroy',
    ]);

});

Route::middleware(['auth', 'can:manage_offers'])->group(function () {
    // Sector and skill
    Route::resource('pilot/sector', SectorController::class);
    Route::resource('pilot/skill', SkillController::class);

    // Offer
    Route::resource('pilot/offer', OfferController::class)->names([
        'index' => 'pilot.offer.index',
        'show' => 'pilot.offer.show',
        'create' => 'pilot.offer.create',
        'edit' => 'pilot.offer.edit',
        'store' => 'pilot.offer.store',
        'update' => 'pilot.offer.update',
        'destroy' => 'pilot.offer.destroy',
    ]);
});


