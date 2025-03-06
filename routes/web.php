<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login.show');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard.show');
})->name('dashboard');

Route::get('/profile', function () {
    return view('profile.show');
})->name('profile');

Route::get('/student_crud', function () {
    return view('student_crud.show');
})->name('student_crud');

Route::get('/dashboard', [DashboardController::class, 'index']);

// Page d'insertion pour les produits
Route::get('dashboard/home', function() {
    return view('dashboard.home');
});

Route::get('/offer/insert', function() {
    return view('offer.insert');
});

Route::get('/pilot/insert', function() {
    return view('pilot.insert');
});

Route::get('/company/insert', function() {
    return view('company.insert');
});

Route::get('/student/insert', function() {
    return view('student.insert');
});

Route::get('/apply/insert', function() {
    return view('apply.insert');
});

Route::get('/wishlist/insert', function() {
    return view('wishlist.insert');
});
