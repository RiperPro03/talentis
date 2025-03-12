<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display dashboard home page.
     */
    public function index()
    {
        return view('dashboard.home');
    }
}
