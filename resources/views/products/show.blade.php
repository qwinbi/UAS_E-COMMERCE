@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-desert-clay">
                    <i class="fas fa-home mr-2"></i> Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-desert-clay">
                        Produk
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-desert-clay font-medium">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Product Images -->
        <div>
            <div class="bg-white rounded-bunny overflow-hidden shadow-lg mb-4">
                <div class="h-96 bg-gradient-to-br from-cream to-olive flex items-center justify-center">
                    @if($product->image)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                             class="h-full w-full object-cover">
                    @else
                        <i class="fas fa-paw text-9xl text-white opacity-80"></i>
                    @endif
                </div>
            </div>
            
            <!-- Thumbnails -->
            <div class="grid grid-cols-4 gap-2">
                <div class="bg-white rounded-lg p-2 border border-gray-200 cursor-pointer">
                    <div class="h-20 bg-gradient-to-br from-cream to-olive flex items-center justify-center">
                        <i class="fas fa-paw text-3xl text-white"></i>
                    </div>
                </div>
                @for($i = 1; $i <= 3; $i++)
                <div class="bg-white rounded-lg p-2 border border-gray-200 cursor-pointer opacity-50 hover:opacity-100 transition">
                    <div class="h-20 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-2xl text-gray-400"></i>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        
        <!-- Product Info -->
        <div>
            <div class="bg-white rounded-bunny p-6 shadow-lg">
                <!-- Category & Badges -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-desert-clay bg-desert-clay bg-opacity-10 px-3 py-1 rounded-full text-sm">
                        {{ $product->category }}
                    </span>
                    
                    <div class="flex items-center space-x-2">
                        @if($product->stock < 10 && $product->stock > 0)
                            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-fire mr-1"></i> Hampir Habis!
                            </span>
                        @elseif($product->stock == 0)
                            <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-times mr-1"></i> Stok Habis
                            </span>
                        @endif
                        
                        @if($product->price < 50000)
                            <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                <i class="fas fa-tag mr-1"></i> Murah!
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Product Name -->
                <h1 class="text-3xl font-bold text-forest-green mb-2">{{ $product->name }}</h1>
                
                <!-- Rating -->
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400 mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                    </div>
                    <span class="text-gray-600 text-sm">(4.5) • 128 reviews</span>
                </div>
                
                <!-- Price -->
                <div class="mb-6">
                    <div class="text-4xl font-bold text-rum-punch">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>
                    <p class="text-gray-500 text-sm">Harga sudah termasuk PPN</p>
                </div>
                
                <!-- Stock -->
                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-box text-olive mr-2"></i>
                        <span class="font-medium">Stok Tersedia:</span>
                        <span class="ml-2 {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->stock > 0 ? $product->stock . ' unit' : 'Stok habis' }}
                        </span>
                    </div>
                    
                    @if($product->stock > 0 && $product->stock < 20)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                                <p class="text-yellow-700 text-sm">Segera habis! Hanya tersisa {{ $product->stock }} unit.</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Description -->
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-forest-green mb-3">Deskripsi Produk</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-line">{{ $product->description }}</p>
                    </div>
                </div>
                
                <!-- Add to Cart -->
                @auth
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        
                        <!-- Quantity Selector -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah:</label>
                            <div class="flex items-center">
                                <button type="button" 
                                        class="w-10 h-10 border border-gray-300 rounded-l-lg flex items-center justify-center text-gray-600 hover:bg-gray-50 decrement-btn">
                                    <i class="fas fa-minus"></i>
                                </button>
                                
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                                       class="w-20 h-10 border-y border-gray-300 text-center focus:ring-desert-clay focus:border-desert-clay">
                                       
                                <button type="button" 
                                        class="w-10 h-10 border border-gray-300 rounded-r-lg flex items-center justify-center text-gray-600 hover:bg-gray-50 increment-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                                
                                <div class="ml-4 text-sm text-gray-600">
                                    Maks: {{ $product->stock }} unit
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-desert-clay to-rum-punch text-white py-3 rounded-lg hover:opacity-90 transition flex items-center justify-center text-lg font-bold add-to-cart-btn"
                                    {{ $product->stock == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-cart-plus mr-3"></i>
                                {{ $product->stock == 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                            </button>
                            
                            <button type="button" 
                                    class="w-full bg-gradient-to-r from-olive to-forest-green text-white py-3 rounded-lg hover:opacity-90 transition flex items-center justify-center text-lg font-bold">
                                <i class="fas fa-bolt mr-3"></i>
                                Beli Sekarang
                            </button>
                        </div>
                    </form>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-info-circle text-yellow-500 mr-3 text-xl"></i>
                            <div>
                                <p class="font-medium text-yellow-800">Anda perlu login untuk membeli</p>
                                <a href="{{ route('login') }}" class="text-desert-clay hover:underline text-sm">
                                    Klik di sini untuk login
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('login') }}" 
                           class="w-full bg-gradient-to-r from-desert-clay to-rum-punch text-white py-3 rounded-lg hover:opacity-90 transition flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </a>
                        
                        <a href="{{ route('register') }}" 
                           class="w-full bg-gradient-to-r from-olive to-forest-green text-white py-3 rounded-lg hover:opacity-90 transition flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i> Register
                        </a>
                    </div>
                @endauth
            </div>
            
            <!-- Product Details -->
            <div class="bg-white rounded-bunny p-6 shadow-lg mt-6">
                <h3 class="text-lg font-bold text-forest-green mb-4">Detail Produk</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <i class="fas fa-weight text-olive mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Berat</p>
                            <p class="font-medium">500 gram</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <i class="fas fa-ruler-combined text-olive mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Dimensi</p>
                            <p class="font-medium">15 × 10 × 5 cm</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <i class="fas fa-palette text-olive mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Warna</p>
                            <p class="font-medium">Putih, Coklat, Abu-abu</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <i class="fas fa-box-open text-olive mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Material</p>
                            <p class="font-medium">Katun, Poliester</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="bunny-title text-3xl font-bold text-forest-green mb-8">
                <i class="fas fa-random text-desert-clay mr-2"></i> Produk Serupa
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="bg-white rounded-bunny overflow-hidden shadow-lg hover:shadow-xl transition">
                        <div class="h-48 bg-gradient-to-br from-cream to-olive flex items-center justify-center">
                            @if($relatedProduct->image)
                                <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" 
                                     class="h-full w-full object-cover">
                            @else
                                <i class="fas fa-paw text-6xl text-white"></i>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <h4 class="font-bold text-forest-green mb-2 truncate">{{ $relatedProduct->name }}</h4>
                            <p class="text-rum-punch font-bold mb-3">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</p>
                            <a href="{{ route('products.show', $relatedProduct->slug) }}" 
                               class="block text-center bg-cream text-forest-green py-2 rounded-lg hover:bg-olive transition text-sm">
                                <i class="fas fa-eye mr-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity increment/decrement
        const quantityInput = document.getElementById('quantity');
        const maxQuantity = parseInt(quantityInput.max);
        
        document.querySelector('.increment-btn').addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < maxQuantity) {
                quantityInput.value = currentValue + 1;
            }
        });
        
        document.querySelector('.decrement-btn').addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
        
        // Add to cart animation
        const addToCartBtn = document.querySelector('.add-to-cart-btn');
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function(e) {
                if (this.disabled) {
                    e.preventDefault();
                    return;
                }
                
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check mr-3"></i>Ditambahkan!';
                this.classList.add('bg-green-500');
                this.classList.remove('from-desert-clay', 'to-rum-punch');
                
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.classList.remove('bg-green-500');
                    this.classList.add('from-desert-clay', 'to-rum-punch');
                }, 2000);
            });
        }
    });
</script>
@endsection