@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="bunny-title text-4xl font-bold text-forest-green mb-2">
            <i class="fas fa-envelope text-desert-clay mr-2"></i> Hubungi Kami
        </h1>
        <p class="text-gray-600">Punya pertanyaan? Tim kami siap membantu Anda!</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Contact Form -->
        <div class="bg-white rounded-bunny shadow-lg p-6">
            <h2 class="text-xl font-bold text-forest-green mb-6">Kirim Pesan</h2>
            
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                        <input type="text" 
                               name="name" 
                               required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                               value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" 
                               name="email" 
                               required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                               value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subjek *</label>
                        <input type="text" 
                               name="subject" 
                               required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                               value="{{ old('subject') }}">
                        @error('subject')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan *</label>
                        <textarea name="message" 
                                  rows="5"
                                  required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <button type="submit" 
                                class="w-full py-3 bg-gradient-to-r from-desert-clay to-rum-punch text-white rounded-lg hover:opacity-90 transition font-bold">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Pesan
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Contact Information -->
        <div class="space-y-6">
            <!-- Contact Cards -->
            <div class="bg-white rounded-bunny shadow-lg p-6">
                <h2 class="text-xl font-bold text-forest-green mb-6">Informasi Kontak</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-desert-clay text-white rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Alamat</h3>
                            <p class="text-gray-600 mt-1">
                                Jl. Kelinci No. 123<br>
                                Jakarta Selatan, 12345<br>
                                Indonesia
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-olive text-forest-green rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Telepon</h3>
                            <p class="text-gray-600 mt-1">
                                +62 812 3456 7890<br>
                                (021) 123-4567
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-cream text-rum-punch rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Email</h3>
                            <p class="text-gray-600 mt-1">
                                hello@bunnypops.com<br>
                                support@bunnypops.com
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-forest-green text-cream rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Jam Operasional</h3>
                            <p class="text-gray-600 mt-1">
                                Senin - Jumat: 08:00 - 22:00 WIB<br>
                                Sabtu - Minggu: 09:00 - 20:00 WIB
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Social Media -->
            <div class="bg-white rounded-bunny shadow-lg p-6">
                <h2 class="text-xl font-bold text-forest-green mb-6">Ikuti Kami</h2>
                
                <div class="flex space-x-4">
                    <a href="#" class="flex-1 text-center p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition">
                        <i class="fab fa-facebook text-blue-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-gray-900">Facebook</p>
                    </a>
                    
                    <a href="#" class="flex-1 text-center p-4 bg-pink-50 border border-pink-200 rounded-lg hover:bg-pink-100 transition">
                        <i class="fab fa-instagram text-pink-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-gray-900">Instagram</p>
                    </a>
                    
                    <a href="#" class="flex-1 text-center p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition">
                        <i class="fab fa-whatsapp text-green-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-gray-900">WhatsApp</p>
                    </a>
                </div>
            </div>
            
            <!-- FAQ -->
            <div class="bg-white rounded-bunny shadow-lg p-6">
                <h2 class="text-xl font-bold text-forest-green mb-6">FAQ</h2>
                
                <div class="space-y-4">
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="font-medium text-gray-900 mb-2">Bagaimana cara melakukan pembelian?</h3>
                        <p class="text-sm text-gray-600">Daftar/Login > Pilih produk > Tambah ke keranjang > Checkout > Bayar > Selesai!</p>
                    </div>
                    
                    <div class="border-b border-gray-200 pb-4">
                        <h3 class="font-medium text-gray-900 mb-2">Berapa lama pengiriman?</h3>
                        <p class="text-sm text-gray-600">Pengiriman reguler 3-5 hari kerja, ekspres 1-2 hari kerja.</p>
                    </div>
                    
                    <div>
                        <h3 class="font-medium text-gray-900 mb-2">Bagaimana cara pengembalian?</h3>
                        <p class="text-sm text-gray-600">Hubungi customer service dalam 7 hari setelah produk diterima.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Map (optional) -->
    <div class="mt-8 bg-white rounded-bunny shadow-lg p-6">
        <h2 class="text-xl font-bold text-forest-green mb-6">Lokasi Kami</h2>
        <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
            <div class="text-center">
                <i class="fas fa-map-marked-alt text-4xl text-gray-400 mb-4"></i>
                <p class="text-gray-600">Peta lokasi akan ditampilkan di sini</p>
            </div>
        </div>
    </div>
</div>
@endsection