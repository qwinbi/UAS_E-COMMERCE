<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

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

    public function products(Request $request)
    {
        $query = Product::query();
        
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }
        
        // Filter by search
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Filter by stock availability
        if ($request->has('stock')) {
            if ($request->stock == 'in_stock') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock == 'out_of_stock') {
                $query->where('stock', '=', 0);
            } elseif ($request->stock == 'low_stock') {
                $query->where('stock', '<', 10)->where('stock', '>', 0);
            }
        }
        
        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }
        
        $products = $query->paginate(12);
        
        // Get unique categories for filter
        $categories = Product::select('category')->distinct()->pluck('category');
        
        return view('products.index', compact('products', 'categories'));
    }

    public function showProduct($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
            
        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function contact()
    {
        return view('home.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        // Here you would typically send an email or save to database
        // For now, we'll just flash a success message
        
        return redirect()->back()->with('success', 'Pesan Anda telah terkirim! Kami akan menghubungi Anda segera.');
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
        ]);
        
        $query = $request->input('query');
        
        $products = Product::where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->orWhere('category', 'like', '%' . $query . '%')
            ->paginate(12);
            
        return view('products.search', [
            'products' => $products,
            'query' => $query,
            'resultsCount' => $products->total(),
        ]);
    }

    public function categories()
    {
        $categories = Product::select('category')
            ->selectRaw('COUNT(*) as product_count')
            ->groupBy('category')
            ->get();
            
        return view('home.categories', compact('categories'));
    }
}