<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route accessible par tout le monde
Route::get('/', function () {
    return view('welcome');

})->name('home');

// Route pour les utilisateurs non authentifiés
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Route pour les utilisateurs authentifiés
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/test-admin', function () {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json([
                'message' => 'Informations utilisateur',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->getRoleNames(),
                    'permissions' => $user->getAllPermissions()->pluck('name')
                ]
            ], 200);
        }
        return response()->json(['message' => 'Accès refusé'], 403);
    });

    Route::resource('admin/company', CompanyController::class)->names([
        'index' => 'admin.company.index',
        'show' => 'admin.company.show',
        'create' => 'admin.company.create',
        'edit' => 'admin.company.edit',
        'store' => 'admin.company.store',
        'update' => 'admin.company.update',
        'destroy' => 'admin.company.destroy',
    ]);
    Route::resource('company', CompanyController::class);
    Route::get('search/company', [CompanyController::class, 'search'])->name('company.search');

    Route::resource('admin/offer', OfferController::class)->names([
        'index' => 'admin.offer.index',
        'show' => 'admin.offer.show',
        'create' => 'admin.offer.create',
        'edit' => 'admin.offer.edit',
        'store' => 'admin.offer.store',
        'update' => 'admin.offer.update',
        'destroy' => 'admin.offer.destroy',
    ]);
    Route::resource('offer', OfferController::class);
    Route::get('search/offer', [OfferController::class, 'search'])->name('offer.search');

    Route::resource('admin/user', UserController::class)->names([
        'index' => 'admin.user.index',
        'show' => 'admin.user.show',
        'create' => 'admin.user.create',
        'edit' => 'admin.user.edit',
        'store' => 'admin.user.store',
        'update' => 'admin.user.update',
        'destroy' => 'admin.user.destroy',
    ]);

    Route::resource('address', AddressController::class);
    Route::resource('industry', IndustryController::class);
    Route::resource('skill', SkillController::class);

    Route::resource('Promotion', PromotionController::class);
    Route::resource('Sector', SectorController::class);

    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

// Route pour les utilisateurs avec la permission manage_students
Route::middleware(['auth', 'can:manage_students'])->group(function () {
    // TODO: Ajouter les routes pour la gestion des étudiants
});


