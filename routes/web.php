<?php

use Illuminate\Support\Facades\Route;

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