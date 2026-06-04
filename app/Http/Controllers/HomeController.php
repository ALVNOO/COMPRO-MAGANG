<?php

namespace App\Http\Controllers;

use App\Models\DivisiAdmin;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $divisions = DivisiAdmin::where('is_active', true)->orderBy('sort_order')->get();
        return view('home', compact('divisions'));
    }

    public function about()
    {
        return view('about');
    }

    public function program()
    {
        $divisions = DivisiAdmin::where('is_active', true)->orderBy('sort_order')->get();
        return view('program', compact('divisions'));
    }
}
