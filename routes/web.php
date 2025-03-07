<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::get('/test-admin', function () {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
        return response()->json(['message' => 'Vous etes un admin'], 200);
    }
    return response()->json(['message' => 'Acces refuse'], 403);
})->middleware('auth');
