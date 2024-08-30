<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    public const PAGE = 'Home';

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('home.index');
    }
}
