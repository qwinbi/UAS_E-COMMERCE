@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-forest-green to-olive rounded-bunny p-8 md:p-12 mb-12 text-white">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-2/3 mb-8 md:mb-0">
                <h1 class="bunny-title text-4xl md:text-5xl font-bold mb-4">
                    Tentang <span class="text-yellow-300">BUNNYPOPS</span>
                </h1>
                <p class="text-xl opacity-90">
                    Tempat terbaik untuk menemukan produk-produk lucu dan menggemaskan!
                </p>
            </div>
            <div class="md:w-1/3 flex justify-center">
                <div class="relative">
                    <div class="bg-white bg-opacity-20 rounded-full p-8 backdrop-blur-sm">
                        <i class="fas fa-paw text-8xl text-white"></i>
                    </div>
                    <div class="absolute -top-4 -right-4 bg-rum-punch rounded-full p-4 animate-bounce">
                        <i class="fas fa-heart text-3xl text-white"></i>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-desert-clay rounded-full p-4 animate-pulse">
                        <i class="fas fa-star text-3xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- About Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Mission -->
        <div class="bg-white rounded-bunny p-6 shadow-lg">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-rum-punch text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bullseye text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-forest-green mb-2">Misi Kami</h3>
            </div>
            <p class="text-gray-700">
                Menyediakan produk-produk berkualitas dengan desain lucu dan menggemaskan 
                yang dapat membawa kebahagiaan dalam kehidupan sehari-hari.
            </p>
        </div>
        
        <!-- Vision -->
        <div class="bg-white rounded-bunny p-6 shadow-lg">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-desert-clay text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-eye text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-forest-green mb-2">Visi Kami</h3>
            </div>
            <p class="text-gray-700">
                Menjadi platform e-commerce terdepan untuk produk-produk lucu 
                dengan memberikan pengalaman berbelanja yang menyenangkan dan memuaskan.
            </p>
        </div>
        
        <!-- Values -->
        <div class="bg-white rounded-bunny p-6 shadow-lg">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-olive text-forest-green rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-forest-green mb-2">Nilai Kami</h3>
            </div>
            <p class="text-gray-700">
                Kualitas, kejujuran, dan kepuasan pelanggan adalah prioritas utama kami 
                dalam setiap transaksi dan pelayanan.
            </p>
        </div>
    </div>
    
    <!-- About Text -->
    <div class="bg-white rounded-bunny p-8 shadow-lg mb-12">
        <div class="prose max-w-none">
            @if(isset($aboutText) && !empty($aboutText))
                {!! nl2br(e($aboutText)) !!}
            @else
                <div class="text-center py-12">
                    <i class="fas fa-info-circle text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Informasi tentang kami sedang dipersiapkan...</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Team -->
    <div class="mb-12">
        <h2 class="bunny-title text-3xl font-bold text-center text-forest-green mb-8">
            <i class="fas fa-users text-desert-clay mr-2"></i> Tim Kami
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-r from-rum-punch to-desert-clay rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-user text-4xl text-white"></i>
                </div>
                <h3 class="font-bold text-lg text-forest-green">Admin Utama</h3>
                <p class="text-gray-600">Mengelola operasional harian</p>
            </div>
            
            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-r from-olive to-forest-green rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-4xl text-white"></i>
                </div>
                <h3 class="font-bold text-lg text-forest-green">Tim Customer Service</h3>
                <p class="text-gray-600">Siap membantu 24/7</p>
            </div>
            
            <div class="text-center">
                <div class="w-32 h-32 bg-gradient-to-r from-desert-clay to-rum-punch rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-boxes text-4xl text-white"></i>
                </div>
                <h3 class="font-bold text-lg text-forest-green">Tim Gudang</h3>
                <p class="text-gray-600">Memastikan pengiriman tepat waktu</p>
            </div>
        </div>
    </div>
    
    <!-- Contact Info -->
    <div class="bg-gradient-to-r from-cream to-olive rounded-bunny p-8">
        <h2 class="bunny-title text-3xl font-bold text-center text-forest-green mb-8">
            <i class="fas fa-envelope text-desert-clay mr-2"></i> Hubungi Kami
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-bunny p-6">
                <h3 class="font-bold text-xl text-forest-green mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt text-rum-punch mr-2"></i> Alamat
                </h3>
                <p class="text-gray-700">
                    Jl. Kelinci No. 123<br>
                    Jakarta Selatan, 12345<br>
                    Indonesia
                </p>
            </div>
            
            <div class="bg-white rounded-bunny p-6">
                <h3 class="font-bold text-xl text-forest-green mb-4 flex items-center">
                    <i class="fas fa-phone text-desert-clay mr-2"></i> Kontak
                </h3>
                <p class="text-gray-700 mb-2">
                    <i class="fas fa-envelope mr-2 text-olive"></i> hello@bunnypops.com
                </p>
                <p class="text-gray-700">
                    <i class="fas fa-phone mr-2 text-olive"></i> +62 812 3456 7890
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-600 hover:text-rum-punch">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-desert-clay">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-forest-green">
                        <i class="fab fa-whatsapp text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection