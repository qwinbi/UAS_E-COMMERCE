@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="bunny-title text-4xl font-bold text-forest-green mb-2">
            <i class="fas fa-check-circle text-desert-clay mr-2"></i> Checkout
        </h1>
        <p class="text-gray-600">Lengkapi informasi untuk menyelesaikan order Anda</p>
    </div>
    
    <!-- Checkout Steps -->
    <div class="mb-8">
        <div class="flex items-center justify-center">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-desert-clay text-white rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="w-24 h-1 bg-desert-clay"></div>
            </div>
            
            <div class="flex items-center">
                <div class="w-10 h-10 bg-desert-clay text-white rounded-full flex items-center justify-center">
                    <i class="fas fa-user"></i>
                </div>
                <div class="w-24 h-1 bg-gray-300"></div>
            </div>
            
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-300 text-white rounded-full flex items-center justify-center">
                    <i class="fas fa-credit-card"></i>
                </div>
            </div>
        </div>
        
        <div class="flex justify-center mt-2">
            <div class="text-center w-24">
                <p class="text-sm font-medium text-desert-clay">Keranjang</p>
            </div>
            <div class="text-center w-24">
                <p class="text-sm font-medium text-gray-500">Informasi</p>
            </div>
            <div class="text-center w-24">
                <p class="text-sm font-medium text-gray-500">Pembayaran</p>
            </div>
        </div>
    </div>
    
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Form -->
            <div class="lg:col-span-2">
                <!-- Shipping Address -->
                <div class="bg-white rounded-bunny shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-forest-green mb-6 flex items-center">
                        <i class="fas fa-map-marker-alt text-desert-clay mr-2"></i> Alamat Pengiriman
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap Penerima *</label>
                            <input type="text" 
                                   name="receiver_name" 
                                   value="{{ Auth::user()->name }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                                   required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap *</label>
                            <textarea name="shipping_address" 
                                      rows="4"
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                                      placeholder="Contoh: Jl. Kelinci No. 123, RT 01/RW 02, Jakarta Selatan"
                                      required>{{ old('shipping_address') }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi *</label>
                                <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay">
                                    <option>DKI Jakarta</option>
                                    <option>Jawa Barat</option>
                                    <option>Jawa Tengah</option>
                                    <option>Jawa Timur</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kota *</label>
                                <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay">
                                    <option>Jakarta Selatan</option>
                                    <option>Jakarta Pusat</option>
                                    <option>Jakarta Barat</option>
                                    <option>Jakarta Timur</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kode Pos *</label>
                                <input type="text" 
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                                       placeholder="12345">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon *</label>
                            <input type="tel" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" id="save-address" class="h-4 w-4 text-desert-clay">
                            <label for="save-address" class="ml-2 text-sm text-gray-700">
                                Simpan sebagai alamat pengiriman utama
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="bg-white rounded-bunny shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-bold text-forest-green mb-6 flex items-center">
                        <i class="fas fa-credit-card text-desert-clay mr-2"></i> Metode Pembayaran
                    </h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-desert-clay transition">
                                <input type="radio" name="payment_method" value="qris" class="h-4 w-4 text-desert-clay" checked>
                                <div class="ml-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-qrcode text-2xl text-green-500 mr-3"></i>
                                        <div>
                                            <span class="font-medium text-gray-900">QRIS</span>
                                            <p class="text-sm text-gray-500">Bayar dengan scan QR code</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <div>
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:border-desert-clay transition">
                                <input type="radio" name="payment_method" value="va" class="h-4 w-4 text-desert-clay">
                                <div class="ml-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-building text-2xl text-blue-500 mr-3"></i>
                                        <div>
                                            <span class="font-medium text-gray-900">Virtual Account</span>
                                            <p class="text-sm text-gray-500">Transfer bank (BNI, BRI, BCA, Mandiri)</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Payment Instructions -->
                        <div id="qris-instructions" class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h4 class="font-medium text-green-800 mb-2">
                                <i class="fas fa-info-circle mr-2"></i> Cara Bayar dengan QRIS:
                            </h4>
                            <ol class="text-sm text-green-700 list-decimal pl-5 space-y-1">
                                <li>Scan QR code yang akan muncul setelah order</li>
                                <li>Pilih bank/e-wallet Anda</li>
                                <li>Konfirmasi pembayaran</li>
                                <li>Tunggu konfirmasi otomatis dari sistem</li>
                            </ol>
                        </div>
                        
                        <div id="va-instructions" class="bg-blue-50 border border-blue-200 rounded-lg p-4 hidden">
                            <h4 class="font-medium text-blue-800 mb-2">
                                <i class="fas fa-info-circle mr-2"></i> Cara Bayar dengan VA:
                            </h4>
                            <ol class="text-sm text-blue-700 list-decimal pl-5 space-y-1">
                                <li>Nomor VA akan ditampilkan setelah order</li>
                                <li>Transfer ke nomor VA tersebut</li>
                                <li>Gunakan bank yang tersedia (BNI, BRI, BCA, Mandiri)</li>
                                <li>Pembayaran akan dikonfirmasi otomatis</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Order Summary -->
            <div class="lg:col-span-1">
                <!-- Order Summary -->
                <div class="bg-white rounded-bunny shadow-lg sticky top-6">
                    <div class="bg-gradient-to-r from-forest-green to-olive p-4 rounded-t-bunny">
                        <h2 class="font-bold text-lg text-white">
                            <i class="fas fa-shopping-bag mr-2"></i> Detail Order
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        <!-- Order Items -->
                        <div class="mb-6">
                            <h3 class="font-bold text-gray-700 mb-3">Produk</h3>
                            <div class="space-y-4 max-h-60 overflow-y-auto">
                                @foreach($cartItems as $item)
                                    <div class="flex items-center">
                                        <div class="w-16 h-16 bg-gradient-to-br from-cream to-olive rounded-lg flex items-center justify-center flex-shrink-0">
                                            @if($item->product->image)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                                     class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <i class="fas fa-paw text-2xl text-white"></i>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h4 class="font-medium text-sm text-gray-900">{{ $item->product->name }}</h4>
                                            <div class="flex justify-between text-sm text-gray-600">
                                                <span>{{ $item->quantity }} × Rp {{ number_format($item->price_at_added, 0, ',', '.') }}</span>
                                                <span class="font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Order Summary -->
                        <div class="space-y-3 border-t border-gray-200 pt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ongkos Kirim</span>
                                <span class="font-medium text-green-600">Gratis</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Layanan</span>
                                <span class="font-medium">Rp 0</span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-bold text-forest-green">Total</span>
                                    <span class="text-2xl font-bold text-rum-punch">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Terms -->
                        <div class="mt-6">
                            <label class="flex items-start">
                                <input type="checkbox" required class="h-4 w-4 text-desert-clay mt-1">
                                <span class="ml-2 text-sm text-gray-700">
                                    Saya menyetujui 
                                    <a href="#" class="text-desert-clay hover:underline">Syarat & Ketentuan</a> 
                                    dan 
                                    <a href="#" class="text-desert-clay hover:underline">Kebijakan Pengembalian</a>
                                </span>
                            </label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full mt-6 py-3 bg-gradient-to-r from-desert-clay to-rum-punch text-white rounded-lg hover:opacity-90 transition text-lg font-bold flex items-center justify-center">
                            <i class="fas fa-lock mr-2"></i> Buat Order Sekarang
                        </button>
                        
                        <!-- Security Info -->
                        <div class="mt-4 text-center">
                            <div class="flex items-center justify-center text-sm text-gray-500">
                                <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                                <span>Transaksi 100% Aman dan Terlindungi</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Help Section -->
                <div class="bg-white rounded-bunny shadow-lg mt-6 p-6">
                    <h3 class="font-bold text-gray-700 mb-4 flex items-center">
                        <i class="fas fa-question-circle text-desert-clay mr-2"></i> Butuh Bantuan?
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-sm">
                            <i class="fas fa-headset text-olive mr-2"></i>
                            <span>Customer Service: 1500-123</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-clock text-olive mr-2"></i>
                            <span>Operasional: 08:00 - 22:00 WIB</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <i class="fas fa-envelope text-olive mr-2"></i>
                            <span>Email: help@bunnypops.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide payment instructions
        const qrisRadio = document.querySelector('input[value="qris"]');
        const vaRadio = document.querySelector('input[value="va"]');
        const qrisInstructions = document.getElementById('qris-instructions');
        const vaInstructions = document.getElementById('va-instructions');
        
        qrisRadio.addEventListener('change', function() {
            if (this.checked) {
                qrisInstructions.classList.remove('hidden');
                vaInstructions.classList.add('hidden');
            }
        });
        
        vaRadio.addEventListener('change', function() {
            if (this.checked) {
                qrisInstructions.classList.add('hidden');
                vaInstructions.classList.remove('hidden');
            }
        });
        
        // Form validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const termsChecked = document.querySelector('input[type="checkbox"][required]').checked;
            if (!termsChecked) {
                e.preventDefault();
                alert('Anda harus menyetujui syarat dan ketentuan');
            }
        });
    });
</script>
@endsection