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

// Route pour les utilisateurs authentifiés
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


//    Route::resource('admin/company', CompanyController::class)->names([
//        'index' => 'admin.company.index',
//        'show' => 'admin.company.show',
//        'create' => 'admin.company.create',
//        'edit' => 'admin.company.edit',
//        'store' => 'admin.company.store',
//        'update' => 'admin.company.update',
//        'destroy' => 'admin.company.destroy',
//    ]);
    Route::resource('company', CompanyController::class);
    Route::post('company/{company}/rate', [CompanyController::class, 'rate'])->name('company.rate');

//    Route::resource('admin/offer', OfferController::class)->names([
//        'index' => 'admin.offer.index',
//        'show' => 'admin.offer.show',
//        'create' => 'admin.offer.create',
//        'edit' => 'admin.offer.edit',
//        'store' => 'admin.offer.store',
//        'update' => 'admin.offer.update',
//        'destroy' => 'admin.offer.destroy',
//    ]);
    Route::resource('offer', OfferController::class);
    //Candidature
    Route::get('/offer/{offer}/apply', [ApplicationController::class, 'create'])->name('apply.create');
    Route::post('/offer/{offer}/apply', [ApplicationController::class, 'store'])->name('apply.store');
    Route::get('my/applications', [ApplicationController::class, 'index'])->name('apply.index');
    Route::delete('/offer/{offer}/apply', [ApplicationController::class, 'destroy'])->name('apply.remove');


    Route::get('my/wish-list', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('my/wish-list/{offer}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('my/wish-list/{offer}', [WishListController::class, 'remove'])->name('wishlist.remove');

    //Profile
    Route::get('my/profil', [UserController::class, 'profil'])->name('profil.show');
    Route::get('pilot/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

});

// Route pour les utilisateurs avec la permission manage_students
Route::middleware(['auth', 'can:manage_students'])->group(function () { // auth:pilot ou can:manage_students
    Route::resource('pilot/student', StudentController::class);

    Route::get('pilot/apply', [ApplicationController::class, 'index'])->name('pilot.apply.index');
    Route::delete('pilot/apply/{offer}/{user}', [ApplicationController::class, 'destroy'])->name('pilot.apply.remove');
});


Route::middleware(['auth', 'can:manage_students'])->group(function () {
    Route::resource('pilot/promotion', PromotionController::class);

});
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

