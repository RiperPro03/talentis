<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\companiesController;

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



Route::get('/companies', function () {
    
    $companies = [
        ['name' => 'Spotify', 'logo' => 'spotify.png', 'location' => 'Australia', 'jobs' => 6],
        ['name' => 'Facebook', 'logo' => 'facebook.png', 'location' => 'USA', 'jobs' => 6],
        ['name' => 'Google', 'logo' => 'google.png', 'location' => 'China', 'jobs' => 6],
        ['name' => 'Android', 'logo' => 'android.png', 'location' => 'Dubai', 'jobs' => 6],
        ['name' => 'Lenovo', 'logo' => 'lenovo.png', 'location' => 'Pakistan', 'jobs' => 6],
        ['name' => 'Shreethemes', 'logo' => 'shreethemes.png', 'location' => 'India', 'jobs' => 6],
        ['name' => 'Skype', 'logo' => 'skype.png', 'location' => 'Rush', 'jobs' => 6],
        ['name' => 'Snapchat', 'logo' => 'snapchat.png', 'location' => 'Turkey', 'jobs' => 6],
    ];
    return view('companies.show', ['companies'=> $companies]);
})->name('companies');


