<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('login.show');
})->name('login');


Route::get('/test-admin', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return response()->json(['message' => 'Vous etes un admin'], 200);
    }
    return response()->json(['message' => 'Acces refuse'], 403);
});