<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
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


// Route accessible par tout le monde
Route::get('/', [WelcomeController::class, 'index'])->name('home');

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
    Route::get('search/company', [CompanyController::class, 'search'])->name('company.search');

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
    Route::get('search/offer', [OfferController::class, 'search'])->name('offer.search');
    //Candidature
    Route::get('/offer/{offer}/apply', [ApplicationController::class, 'create'])->name('apply.create');
    Route::post('/offer/{offer}/apply', [ApplicationController::class, 'store'])->name('apply.store');
    Route::get('my/applications', [ApplicationController::class, 'index'])->name('apply.index');
    Route::delete('/offer/{offer}/apply', [ApplicationController::class, 'destroy'])->name('apply.remove');


    Route::get('my/wish-list', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('my/wish-list/{offer}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('my/wish-list/{offer}', [WishListController::class, 'remove'])->name('wishlist.remove');


    Route::resource('address', AddressController::class);
    Route::resource('industry', IndustryController::class);
    Route::resource('skill', SkillController::class);
    Route::resource('admin/user', UserController::class);
    Route::resource('Promotion', PromotionController::class);
    Route::resource('Sector', SectorController::class);
});

// Route pour les utilisateurs avec la permission manage_students
Route::middleware(['auth', 'can:manage_students'])->group(function () {
    Route::resource('pilot/student', StudentController::class);
});

Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
