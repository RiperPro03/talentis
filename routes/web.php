<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

    Route::resource('company', CompanyController::class);
    Route::resource('address', AddressController::class);
    Route::resource('industry', IndustryController::class);
    Route::resource('offer', OfferController::class);
    Route::resource('skill', SkillController::class);
    Route::resource('user', UserController::class);
    Route::resource('Promotion', PromotionController::class);
    Route::resource('Sector', SectorController::class);

});

// Route pour les utilisateurs avec la permission manage_students
Route::middleware(['auth', 'can:manage_students'])->group(function () {
    // TODO: Ajouter les routes pour la gestion des étudiants
});

Route::get('/dashboard', function () {
    return view('dashboard.show');
})->name('dashboard');

Route::get('/profile', function () {
     $user = Auth::user(); // Récupère l'utilisateur connecté
    return view('profile.show', compact('user'));
})->name('profile');


Route::get('/student_crud', function () {
    return view('student_crud.show');
})->name('student_crud');