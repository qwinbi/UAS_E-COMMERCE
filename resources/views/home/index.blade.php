@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="mb-12">
        <div class="bg-gradient-to-r from-primary to-secondary rounded-bunny p-8 text-light">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="bunny-title text-4xl md:text-5xl font-bold mb-4">
                        Selamat Datang di <span class="text-yellow-300">BUNNYPOPS!</span>
                    </h1>
                    <p class="text-xl mb-6">Temukan produk-produk lucu dan menggemaskan untuk menghiasi hari-harimu.</p>
                    <a href="{{ route('products.index') }}" class="btn-primary px-6 py-3 rounded-full text-lg font-bold inline-block pulse">
                        <i class="fas fa-shopping-bag mr-2"></i> Belanja Sekarang
                    </a>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <div class="relative">
                        <div class="bg-light rounded-full p-8">
                            <i class="fas fa-paw text-9xl text-primary"></i>
                        </div>
                        <div class="absolute -top-4 -right-4 bg-accent rounded-full p-4">
                            <i class="fas fa-heart text-4xl text-primary"></i>
                        </div>
                        <div class="absolute -bottom-4 -left-4 bg-yellow-400 rounded-full p-4">
                            <i class="fas fa-star text-4xl text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="mb-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="bunny-title text-3xl font-bold text-dark">
                <i class="fas fa-crown text-yellow-500 mr-2"></i> Produk Unggulan
            </h2>
            <a href="{{ route('products.index') }}" class="text-primary hover:underline">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-bunny overflow-hidden shadow-lg card-hover">
                    <div class="relative">
                        <div class="h-48 bg-gradient-to-br from-accent to-light flex items-center justify-center">
                            @if($product->image)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                            @else
                                <i class="fas fa-paw text-6xl text-primary"></i>
                            @endif
                        </div>
                        @if($product->stock < 10)
                            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-fire mr-1"></i> Terbatas!
                            </span>
                        @endif
                    </div>
                    
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 text-dark truncate">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                        
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-primary font-bold text-xl">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="text-sm text-gray-500">
                                Stok: {{ $product->stock }}
                            </span>
                        </div>
                        
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" 
                                    class="w-full bg-primary text-white py-2 rounded-bunny hover:bg-opacity-90 transition flex items-center justify-center add-to-cart"
                                    {{ $product->stock == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-cart-plus mr-2"></i>
                                {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Categories -->
    <section class="mb-12">
        <h2 class="bunny-title text-3xl font-bold text-dark mb-8 text-center">
            <i class="fas fa-tags text-secondary mr-2"></i> Kategori Produk
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $categories = ['Toys', 'Accessories', 'Clothing', 'Home', 'Stationery'];
                $icons = ['fa-gamepad', 'fa-gem', 'fa-tshirt', 'fa-home', 'fa-book'];
                $colors = ['bg-purple-500', 'bg-pink-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500'];
            @endphp
            
            @foreach($categories as $index => $category)
                <a href="{{ route('products.index') }}?category={{ $category }}" 
                   class="bg-white rounded-bunny p-6 text-center shadow-md hover:shadow-xl transition card-hover">
                    <div class="{{ $colors[$index] }} text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas {{ $icons[$index] }} text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-dark">{{ $category }}</h3>
                    <p class="text-gray-600 text-sm mt-2">Lihat produk</p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Features -->
    <section class="mb-12">
        <div class="bg-gradient-to-r from-accent to-light rounded-bunny p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-shipping-fast text-3xl text-primary"></i>
                    </div>
                    <h3 class="font-bold text-xl text-dark mb-2">Gratis Ongkir</h3>
                    <p class="text-gray-700">Untuk pembelian di atas Rp 200.000</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-shield-alt text-3xl text-primary"></i>
                    </div>
                    <h3 class="font-bold text-xl text-dark mb-2">Garansi 100%</h3>
                    <p class="text-gray-700">Kepuasan pelanggan adalah prioritas</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-headset text-3xl text-primary"></i>
                    </div>
                    <h3 class="font-bold text-xl text-dark mb-2">Support 24/7</h3>
                    <p class="text-gray-700">Tim kami siap membantu Anda</p>
                </div>
            </div>
        </div>
    </section>
@endsection