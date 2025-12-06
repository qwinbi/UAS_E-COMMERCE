@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="bunny-title text-4xl font-bold text-forest-green mb-2">
            <i class="fas fa-shopping-bag text-desert-clay mr-2"></i> Semua Produk
        </h1>
        <p class="text-gray-600">Temukan produk-produk lucu dan menggemaskan untuk Anda!</p>
    </div>
    
    <!-- Filters -->
    <div class="bg-white rounded-bunny p-4 mb-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div class="mb-4 md:mb-0">
                <span class="text-gray-700">Menampilkan {{ $products->total() }} produk</span>
            </div>
            
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                <div>
                    <select class="w-full md:w-auto border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay">
                        <option>Semua Kategori</option>
                        <option>Toys</option>
                        <option>Accessories</option>
                        <option>Clothing</option>
                        <option>Home</option>
                        <option>Stationery</option>
                    </select>
                </div>
                
                <div>
                    <select class="w-full md:w-auto border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay">
                        <option>Urutkan: Terbaru</option>
                        <option>Harga: Terendah</option>
                        <option>Harga: Tertinggi</option>
                        <option>Nama: A-Z</option>
                    </select>
                </div>
                
                <div class="relative">
                    <input type="text" placeholder="Cari produk..." 
                           class="w-full md:w-64 border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:ring-desert-clay focus:border-desert-clay">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @forelse($products as $product)
            <div class="bg-white rounded-bunny overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300 card-hover">
                <!-- Product Image -->
                <div class="relative">
                    <div class="h-56 bg-gradient-to-br from-olive to-cream flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="h-full w-full object-cover">
                        @else
                            <i class="fas fa-paw text-8xl text-white opacity-80"></i>
                        @endif
                    </div>
                    
                    <!-- Badges -->
                    <div class="absolute top-3 left-3">
                        @if($product->stock < 10 && $product->stock > 0)
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-fire mr-1"></i> Hampir Habis!
                            </span>
                        @elseif($product->stock == 0)
                            <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-times mr-1"></i> Stok Habis
                            </span>
                        @endif
                    </div>
                    
                    <div class="absolute top-3 right-3">
                        @if($product->price < 50000)
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-tag mr-1"></i> Murah!
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="p-4">
                    <div class="mb-2">
                        <span class="text-xs text-desert-clay bg-desert-clay bg-opacity-10 px-2 py-1 rounded">
                            {{ $product->category }}
                        </span>
                    </div>
                    
                    <h3 class="font-bold text-lg text-forest-green mb-2 truncate">
                        {{ $product->name }}
                    </h3>
                    
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                        {{ Str::limit($product->description, 80) }}
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-2xl font-bold text-rum-punch">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-box mr-1"></i>
                            <span>{{ $product->stock }} stok</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
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
                                        class="w-full bg-gradient-to-r from-desert-clay to-rum-punch text-white py-2 rounded-lg hover:opacity-90 transition flex items-center justify-center add-to-cart"
                                        {{ $product->stock == 0 ? 'disabled' : '' }}>
                                    <i class="fas fa-cart-plus mr-2"></i>
                                    {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" 
                               class="block w-full text-center bg-gradient-to-r from-desert-clay to-rum-punch text-white py-2 rounded-lg hover:opacity-90 transition">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login untuk Beli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-600 mb-2">Tidak ada produk</h3>
                <p class="text-gray-500">Produk akan segera tersedia!</p>
            </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if($products->hasPages())
        <div class="bg-white rounded-bunny p-4 shadow-sm">
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
        </div>
    @endif
    
    <!-- Categories Section -->
    <div class="mt-12">
        <h2 class="bunny-title text-3xl font-bold text-center text-forest-green mb-8">
            <i class="fas fa-tags text-desert-clay mr-2"></i> Kategori Produk
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            @php
                $categories = [
                    ['name' => 'Toys', 'icon' => 'fa-gamepad', 'color' => 'bg-purple-500', 'count' => $products->where('category', 'Toys')->count()],
                    ['name' => 'Accessories', 'icon' => 'fa-gem', 'color' => 'bg-pink-500', 'count' => $products->where('category', 'Accessories')->count()],
                    ['name' => 'Clothing', 'icon' => 'fa-tshirt', 'color' => 'bg-blue-500', 'count' => $products->where('category', 'Clothing')->count()],
                    ['name' => 'Home', 'icon' => 'fa-home', 'color' => 'bg-green-500', 'count' => $products->where('category', 'Home')->count()],
                    ['name' => 'Stationery', 'icon' => 'fa-book', 'color' => 'bg-yellow-500', 'count' => $products->where('category', 'Stationery')->count()],
                ];
            @endphp
            
            @foreach($categories as $category)
                <a href="{{ route('products.index') }}?category={{ $category['name'] }}" 
                   class="bg-white rounded-bunny p-6 text-center shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="{{ $category['color'] }} text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas {{ $category['icon'] }} text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-dark mb-1">{{ $category['name'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $category['count'] }} produk</p>
                </a>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add to cart animation
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function(e) {
                if (this.disabled) {
                    e.preventDefault();
                    return;
                }
                
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check mr-2"></i>Ditambahkan!';
                this.classList.add('bg-green-500');
                this.classList.remove('from-desert-clay', 'to-rum-punch');
                
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.classList.remove('bg-green-500');
                    this.classList.add('from-desert-clay', 'to-rum-punch');
                }, 2000);
            });
        });
    });
</script>
@endsection