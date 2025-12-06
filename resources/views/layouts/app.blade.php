<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BUNNYPOPS') - E-commerce Lucu</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Comic+Neue:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --rum-punch: #822621;
            --desert-clay: #af6451;
            --olive: #abba99;
            --forest-green: #162c11;
            --cream: #f7edd4;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--cream);
        }
        
        .bunny-title {
            font-family: 'Comic Neue', cursive;
        }
        
        .btn-primary {
            background-color: var(--rum-punch);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #6a1f1b;
        }
        
        .btn-secondary {
            background-color: var(--desert-clay);
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #9a5a4a;
        }
        
        .bg-primary {
            background-color: var(--rum-punch);
        }
        
        .text-primary {
            color: var(--rum-punch);
        }
        
        .bg-secondary {
            background-color: var(--desert-clay);
        }
        
        .text-secondary {
            color: var(--desert-clay);
        }
        
        .bg-accent {
            background-color: var(--olive);
        }
        
        .text-accent {
            color: var(--olive);
        }
        
        .bg-dark {
            background-color: var(--forest-green);
        }
        
        .text-dark {
            color: var(--forest-green);
        }
        
        .bg-light {
            background-color: var(--cream);
        }
        
        .text-light {
            color: var(--cream);
        }
        
        .rounded-bunny {
            border-radius: 20px;
        }
        
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .bounce {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-light min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-primary text-light shadow-lg">
        <nav class="container mx-auto px-4 py-3">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="relative">
                            <i class="fas fa-paw text-3xl text-light bounce"></i>
                            <span class="bunny-title text-2xl font-bold ml-2">BUNNYPOPS</span>
                        </div>
                    </a>
                </div>
                
                <div class="flex-1 max-w-2xl mx-4 mb-4 md:mb-0">
                    <form action="{{ route('products.index') }}" method="GET" class="relative">
                        <input type="text" name="search" placeholder="Cari produk lucu..." 
                               class="w-full px-4 py-2 rounded-full border-0 focus:ring-2 focus:ring-secondary">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-secondary text-light px-4 py-1 rounded-full hover:bg-opacity-90">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('cart.index') }}" class="relative">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @php
                                $cartCount = Auth::user()->cartItems()->count();
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                        
                        <div class="relative group">
                            <button class="flex items-center space-x-2">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg hidden group-hover:block z-10">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                @endif
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-history mr-2"></i>Riwayat Order
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary px-4 py-2 rounded-full">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary px-4 py-2 rounded-full">
                            <i class="fas fa-user-plus mr-2"></i>Register
                        </a>
                    @endauth
                </div>
            </div>
            
            <div class="mt-4 flex justify-center space-x-6">
                <a href="{{ route('home') }}" class="hover:text-yellow-200">
                    <i class="fas fa-home mr-1"></i> Home
                </a>
                <a href="{{ route('products.index') }}" class="hover:text-yellow-200">
                    <i class="fas fa-shopping-bag mr-1"></i> Produk
                </a>
                <a href="{{ route('about') }}" class="hover:text-yellow-200">
                    <i class="fas fa-info-circle mr-1"></i> About
                </a>
                <a href="{{ route('cart.index') }}" class="hover:text-yellow-200">
                    <i class="fas fa-shopping-cart mr-1"></i> Keranjang
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg border border-green-300">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg border border-red-300">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-paw text-2xl text-accent"></i>
                        <span class="bunny-title text-xl font-bold">BUNNYPOPS</span>
                    </div>
                    <p class="text-gray-300">Toko online dengan produk-produk lucu dan menggemaskan untuk semua kalangan.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="hover:text-accent"><i class="fas fa-chevron-right mr-2"></i> Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-accent"><i class="fas fa-chevron-right mr-2"></i> Produk</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-accent"><i class="fas fa-chevron-right mr-2"></i> About</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-accent"><i class="fas fa-chevron-right mr-2"></i> Keranjang</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-bold mb-4">Contact</h3>
                    <p class="text-gray-300 mb-2"><i class="fas fa-envelope mr-2"></i> hello@bunnypops.com</p>
                    <p class="text-gray-300 mb-2"><i class="fas fa-phone mr-2"></i> +62 812 3456 7890</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-light hover:text-accent"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-light hover:text-accent"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-light hover:text-accent"><i class="fab fa-twitter text-xl"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>{{ \App\Models\Setting::getValue('footer_text', '© 2024 BUNNYPOPS - All rights reserved') }}</p>
                <p class="mt-2 text-sm">Made with <i class="fas fa-heart text-red-400"></i> for UAS Web Engineering</p>
            </div>
        </div>
    </footer>

    <script>
        // Toggle mobile menu
        document.addEventListener('DOMContentLoaded', function() {
            // Cart count update
            function updateCartCount() {
                fetch('/api/v1/cart', {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const cartCount = data.data.items.length;
                        const cartBadge = document.querySelector('.cart-badge');
                        if (cartBadge) {
                            cartBadge.textContent = cartCount;
                            cartBadge.classList.toggle('hidden', cartCount === 0);
                        }
                    }
                });
            }
            
            // Update cart count if user is logged in
            @if(auth()->check())
                updateCartCount();
            @endif
            
            // Add to cart animation
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check mr-2"></i>Ditambahkan!';
                    this.classList.add('bg-green-500');
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('bg-green-500');
                        updateCartCount();
                    }, 1500);
                });
            });
        });
    </script>
</body>
</html>