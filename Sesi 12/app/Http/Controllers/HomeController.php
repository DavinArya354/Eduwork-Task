<?php

namespace App\Http\Controllers;

use App\Support\StoreCatalog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $showcaseProducts = StoreCatalog::products();
        
        return view('home.index', compact('showcaseProducts'));
    }

    public function indexLayoutComponent()
    {
        return view('home.index-layout-component');
    }
}
