<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->take(8)->get();
        return view('home.index', compact('products'));
    }

    public function about()
    {
        $aboutText = Setting::getValue('about_text', '');
        return view('home.about', compact('aboutText'));
    }

    public function products()
    {
        $products = Product::paginate(12);
        return view('products.index', compact('products'));
    }
}