@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="bunny-title text-4xl font-bold text-forest-green mb-2">
            <i class="fas fa-shopping-cart text-desert-clay mr-2"></i> Keranjang Belanja
        </h1>
        <p class="text-gray-600">Review dan kelola item di keranjang Anda</p>
    </div>
    
    @if($cartItems->isEmpty())
        <!-- Empty Cart -->
        <div class="bg-white rounded-bunny shadow-lg p-12 text-center">
            <div class="w-32 h-32 bg-gradient-to-br from-cream to-olive rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-cart text-6xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-700 mb-4">Keranjang Anda Kosong</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Belum ada produk yang ditambahkan ke keranjang. Mulai belanja dan temukan produk lucu untuk Anda!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-desert-clay to-rum-punch text-white rounded-lg hover:opacity-90 transition inline-flex items-center justify-center">
                    <i class="fas fa-shopping-bag mr-2"></i> Mulai Belanja
                </a>
                <a href="{{ route('home') }}" 
                   class="px-6 py-3 bg-cream text-forest-green rounded-lg hover:bg-olive transition inline-flex items-center justify-center">
                    <i class="fas fa-home mr-2"></i> Kembali ke Home
                </a>
            </div>
        </div>
    @else
        <!-- Cart Items -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Items List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-bunny shadow-lg overflow-hidden">
                    <!-- Cart Header -->
                    <div class="bg-gradient-to-r from-cream to-olive p-4">
                        <div class="flex justify-between items-center">
                            <h2 class="font-bold text-lg text-forest-green">
                                <i class="fas fa-boxes mr-2"></i> {{ $cartItems->count() }} Item di Keranjang
                            </h2>
                            <a href="{{ route('products.index') }}" class="text-desert-clay hover:underline text-sm">
                                <i class="fas fa-plus mr-1"></i> Tambah Produk Lain
                            </a>
                        </div>
                    </div>
                    
                    <!-- Cart Items -->
                    <div class="divide-y divide-gray-100">
                        @foreach($cartItems as $item)
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex flex-col md:flex-row md:items-center">
                                    <!-- Product Image -->
                                    <div class="md:w-24 md:h-24 h-40 mb-4 md:mb-0 flex-shrink-0">
                                        <div class="w-full h-full bg-gradient-to-br from-cream to-olive rounded-lg flex items-center justify-center">
                                            @if($item->product->image)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                                     class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <i class="fas fa-paw text-4xl text-white"></i>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Product Info -->
                                    <div class="flex-1 md:ml-6">
                                        <div class="flex justify-between">
                                            <div>
                                                <h3 class="font-bold text-lg text-forest-green mb-1">{{ $item->product->name }}</h3>
                                                <p class="text-gray-600 text-sm mb-2">{{ $item->product->category }}</p>
                                                <div class="text-xl font-bold text-rum-punch mb-2">
                                                    Rp {{ number_format($item->price_at_added, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            
                                            <!-- Delete Button -->
                                            <form action="{{ route('cart.destroy', $item) }}" method="POST" class="md:self-start">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-500 hover:text-red-700 transition" 
                                                        onclick="return confirm('Hapus item dari keranjang?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <!-- Quantity Control -->
                                        <div class="flex items-center justify-between mt-4">
                                            <div class="flex items-center">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" 
                                                            class="w-8 h-8 border border-gray-300 rounded-l-lg flex items-center justify-center text-gray-600 hover:bg-gray-50 decrement-btn"
                                                            data-item-id="{{ $item->id }}"
                                                            data-min="1"
                                                            data-max="{{ $item->product->stock }}">
                                                        <i class="fas fa-minus text-sm"></i>
                                                    </button>
                                                    
                                                    <input type="number" 
                                                           name="quantity" 
                                                           value="{{ $item->quantity }}" 
                                                           min="1" 
                                                           max="{{ $item->product->stock }}"
                                                           class="w-12 h-8 border-y border-gray-300 text-center text-sm focus:ring-desert-clay focus:border-desert-clay quantity-input"
                                                           data-item-id="{{ $item->id }}">
                                                           
                                                    <button type="button" 
                                                            class="w-8 h-8 border border-gray-300 rounded-r-lg flex items-center justify-center text-gray-600 hover:bg-gray-50 increment-btn"
                                                            data-item-id="{{ $item->id }}"
                                                            data-min="1"
                                                            data-max="{{ $item->product->stock }}">
                                                        <i class="fas fa-plus text-sm"></i>
                                                    </button>
                                                </form>
                                                
                                                <div class="ml-4 text-sm text-gray-600">
                                                    <span class="font-medium">Stok:</span> {{ $item->product->stock }} unit
                                                </div>
                                            </div>
                                            
                                            <!-- Subtotal -->
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Subtotal</p>
                                                <p class="text-lg font-bold text-desert-clay">
                                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Cart Actions -->
                <div class="mt-6 flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.index') }}" 
                       class="flex-1 text-center py-3 bg-cream text-forest-green rounded-lg hover:bg-olive transition">
                        <i class="fas fa-arrow-left mr-2"></i> Lanjut Belanja
                    </a>
                    
                    <form action="{{ route('cart.destroy', 'all') }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full py-3 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 rounded-lg hover:opacity-90 transition"
                                onclick="return confirm('Kosongkan seluruh keranjang?')">
                            <i class="fas fa-trash-alt mr-2"></i> Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-bunny shadow-lg sticky top-6">
                    <!-- Summary Header -->
                    <div class="bg-gradient-to-r from-forest-green to-olive p-4 rounded-t-bunny">
                        <h2 class="font-bold text-lg text-white">
                            <i class="fas fa-receipt mr-2"></i> Ringkasan Order
                        </h2>
                    </div>
                    
                    <!-- Summary Content -->
                    <div class="p-6">
                        <!-- Items Count -->
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Total Item</span>
                            <span class="font-medium">{{ $cartItems->count() }} item</span>
                        </div>
                        
                        <!-- Subtotal -->
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Shipping -->
                        <div class="flex justify-between mb-4">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-medium text-green-600">Gratis</span>
                        </div>
                        
                        <!-- Discount -->
                        <div class="flex justify-between mb-6">
                            <span class="text-gray-600">Diskon</span>
                            <span class="font-medium text-red-600">- Rp 0</span>
                        </div>
                        
                        <!-- Divider -->
                        <div class="border-t border-gray-200 mb-6 pt-4">
                            <!-- Total -->
                            <div class="flex justify-between mb-2">
                                <span class="text-lg font-bold text-forest-green">Total</span>
                                <span class="text-2xl font-bold text-rum-punch">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <p class="text-sm text-gray-500 text-right">Termasuk PPN</p>
                        </div>
                        
                        <!-- Promo Code -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kode Promo</label>
                            <div class="flex">
                                <input type="text" 
                                       placeholder="Masukkan kode promo" 
                                       class="flex-1 border border-gray-300 rounded-l-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay">
                                <button type="button" 
                                        class="bg-desert-clay text-white px-4 py-2 rounded-r-lg hover:opacity-90 transition">
                                    Gunakan
                                </button>
                            </div>
                        </div>
                        
                        <!-- Checkout Button -->
                        <a href="{{ route('checkout.form') }}" 
                           class="block w-full text-center py-3 bg-gradient-to-r from-desert-clay to-rum-punch text-white rounded-lg hover:opacity-90 transition text-lg font-bold mb-4">
                            <i class="fas fa-lock mr-2"></i> Lanjut ke Checkout
                        </a>
                        
                        <!-- Security Info -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt text-blue-500 mr-2"></i>
                                <p class="text-sm text-blue-700">
                                    <strong>Transaksi Aman:</strong> Data Anda terlindungi dengan enkripsi SSL
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Methods -->
                <div class="bg-white rounded-bunny shadow-lg mt-6 p-6">
                    <h3 class="font-bold text-lg text-forest-green mb-4">
                        <i class="fas fa-credit-card mr-2"></i> Metode Pembayaran
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div class="border border-gray-200 rounded-lg p-3 text-center hover:border-desert-clay transition cursor-pointer">
                            <i class="fas fa-qrcode text-2xl text-green-500 mb-2"></i>
                            <p class="text-sm font-medium">QRIS</p>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-3 text-center hover:border-desert-clay transition cursor-pointer">
                            <i class="fas fa-building text-2xl text-blue-500 mb-2"></i>
                            <p class="text-sm font-medium">Virtual Account</p>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-3 text-center hover:border-desert-clay transition cursor-pointer">
                            <i class="fab fa-cc-visa text-2xl text-blue-400 mb-2"></i>
                            <p class="text-sm font-medium">Kartu Kredit</p>
                        </div>
                        
                        <div class="border border-gray-200 rounded-lg p-3 text-center hover:border-desert-clay transition cursor-pointer">
                            <i class="fas fa-mobile-alt text-2xl text-purple-500 mb-2"></i>
                            <p class="text-sm font-medium">E-Wallet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity controls
        document.querySelectorAll('.increment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                const max = parseInt(this.dataset.max);
                const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                let currentValue = parseInt(input.value);
                
                if (currentValue < max) {
                    input.value = currentValue + 1;
                    updateCartItem(itemId, input.value);
                }
            });
        });
        
        document.querySelectorAll('.decrement-btn').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                const min = parseInt(this.dataset.min);
                const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
                let currentValue = parseInt(input.value);
                
                if (currentValue > min) {
                    input.value = currentValue - 1;
                    updateCartItem(itemId, input.value);
                }
            });
        });
        
        // Update cart item via AJAX
        function updateCartItem(itemId, quantity) {
            fetch(`/cart/${itemId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    });
</script>
@endsection