@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="bunny-title text-4xl font-bold text-forest-green mb-2">
            <i class="fas fa-search text-desert-clay mr-2"></i> Hasil Pencarian
        </h1>
        <p class="text-gray-600">
            Menampilkan {{ $resultsCount }} hasil untuk "{{ $query }}"
        </p>
    </div>
    
    @if($resultsCount > 0)
        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($products as $product)
                <div class="bg-white rounded-bunny overflow-hidden shadow-lg hover:shadow-xl transition card-hover">
                    <div class="relative">
                        <div class="h-48 bg-gradient-to-br from-cream to-olive flex items-center justify-center">
                            @if($product->image)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                     class="h-full w-full object-cover">
                            @else
                                <i class="fas fa-paw text-6xl text-white"></i>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-forest-green mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 80) }}</p>
                        
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-2xl font-bold text-rum-punch">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="text-sm text-gray-500">
                                Stok: {{ $product->stock }}
                            </span>
                        </div>
                        
                        <div class="space-y-2">
                            <a href="{{ route('products.show', $product->slug) }}" 
                               class="block w-full text-center bg-cream text-forest-green py-2 rounded-lg hover:bg-olive transition">
                                <i class="fas fa-eye mr-2"></i> Lihat Detail
                            </a>
                            
                            @auth
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" 
                                            class="w-full bg-gradient-to-r from-desert-clay to-rum-punch text-white py-2 rounded-lg hover:opacity-90 transition"
                                            {{ $product->stock == 0 ? 'disabled' : '' }}>
                                        <i class="fas fa-cart-plus mr-2"></i>
                                        {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
            <div class="bg-white rounded-bunny p-4 shadow-sm">
                <div class="flex justify-center">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    @else
        <!-- No Results -->
        <div class="bg-white rounded-bunny shadow-lg p-12 text-center">
            <div class="w-32 h-32 bg-gradient-to-br from-cream to-olive rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-search text-6xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-700 mb-4">Tidak ada hasil ditemukan</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Tidak ada produk yang cocok dengan pencarian "{{ $query }}". Coba kata kunci lain.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-desert-clay to-rum-punch text-white rounded-lg hover:opacity-90 transition inline-flex items-center justify-center">
                    <i class="fas fa-shopping-bag mr-2"></i> Lihat Semua Produk
                </a>
                <a href="{{ route('home') }}" 
                   class="px-6 py-3 bg-cream text-forest-green rounded-lg hover:bg-olive transition inline-flex items-center justify-center">
                    <i class="fas fa-home mr-2"></i> Kembali ke Home
                </a>
            </div>
            
            <!-- Search Suggestions -->
            <div class="mt-8 max-w-md mx-auto">
                <p class="text-gray-600 mb-3">Coba cari dengan:</p>
                <div class="flex flex-wrap gap-2 justify-center">
                    <a href="{{ route('products.index') }}?search=bunny" 
                       class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition">
                        bunny
                    </a>
                    <a href="{{ route('products.index') }}?search=toy" 
                       class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition">
                        toy
                    </a>
                    <a href="{{ route('products.index') }}?search=plush" 
                       class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition">
                        plush
                    </a>
                    <a href="{{ route('products.index') }}?search=sticker" 
                       class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition">
                        sticker
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection