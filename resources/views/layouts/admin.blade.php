<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - BUNNYPOPS</title>
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
            background-color: #f9fafb;
        }
        
        .bunny-title {
            font-family: 'Comic Neue', cursive;
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--forest-green), #1a3a15);
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            transition: all 0.3s;
        }
        
        .sidebar-header {
            background-color: rgba(130, 38, 33, 0.9);
            padding: 20px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #cbd5e0;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        
        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--desert-clay);
        }
        
        .sidebar-menu a.active {
            background-color: rgba(175, 100, 81, 0.2);
            color: white;
            border-left-color: var(--desert-clay);
        }
        
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        .navbar {
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 15px 20px;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .btn-admin {
            background-color: var(--rum-punch);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-admin:hover {
            background-color: #6a1f1b;
        }
        
        .btn-admin-secondary {
            background-color: var(--desert-clay);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-admin-secondary:hover {
            background-color: #9a5a4a;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="flex items-center space-x-3">
                <div class="bg-white rounded-full p-2">
                    <i class="fas fa-paw text-xl text-primary"></i>
                </div>
                <div>
                    <h2 class="bunny-title text-xl font-bold text-white">BUNNYPOPS</h2>
                    <p class="text-xs text-gray-300">Admin Panel</p>
                </div>
            </div>
        </div>
        
        <div class="py-4">
            <div class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box mr-3"></i>
                    Produk
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    Order
                    @php
                        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
                    @endphp
                    @if($pendingOrders > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $pendingOrders }}
                        </span>
                    @endif
                </a>
                
                <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog mr-3"></i>
                    Pengaturan
                </a>
                
                <div class="px-6 py-4 mt-8">
                    <div class="text-xs text-gray-400 uppercase mb-2">Quick Actions</div>
                    <a href="{{ route('admin.products.create') }}" class="block text-center bg-desert-clay text-white py-2 rounded-lg mb-2">
                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                    </a>
                    <a href="/" target="_blank" class="block text-center bg-olive text-forest-green py-2 rounded-lg">
                        <i class="fas fa-external-link-alt mr-2"></i>Lihat Website
                    </a>
                </div>
            </div>
        </div>
        
        <div class="absolute bottom-0 left-0 right-0 p-4">
            <div class="bg-rum-punch bg-opacity-20 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-rum-punch"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-gray-300 text-xs">{{ Auth::user()->role }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold text-forest-green">
                        <i class="fas fa-@yield('icon', 'home') mr-2"></i>
                        @yield('title', 'Dashboard')
                    </h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative group">
                        <button class="relative">
                            <i class="fas fa-bell text-xl text-gray-600"></i>
                            @php
                                $unreadCount = \App\Models\Notification::where('is_read', false)->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="notification-badge">{{ $unreadCount }}</span>
                            @endif
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50 hidden group-hover:block">
                            <div class="p-4 border-b">
                                <div class="flex justify-between items-center">
                                    <h3 class="font-bold">Notifikasi</h3>
                                    @if($unreadCount > 0)
                                        <form action="{{ route('admin.notifications.read-all') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs text-desert-clay hover:underline">
                                                Tandai semua dibaca
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="max-h-96 overflow-y-auto">
                                @php
                                    $notifications = \App\Models\Notification::latest()->take(10)->get();
                                @endphp
                                
                                @if($notifications->isEmpty())
                                    <div class="p-4 text-center text-gray-500">
                                        <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                        <p>Tidak ada notifikasi</p>
                                    </div>
                                @else
                                    @foreach($notifications as $notification)
                                        <div class="p-4 border-b hover:bg-gray-50 {{ $notification->is_read ? '' : 'bg-blue-50' }}">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    @if($notification->type === 'order_paid')
                                                        <i class="fas fa-money-bill-wave text-green-500 mr-2"></i>
                                                    @else
                                                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                                    @endif
                                                    <span class="font-medium">{{ $notification->data['message'] ?? 'Notifikasi' }}</span>
                                                    <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                                
                                                @if(!$notification->is_read)
                                                    <form action="{{ route('admin.notifications.read', $notification) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="text-xs text-desert-clay hover:underline">
                                                            Tandai baca
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="p-4 text-center border-t">
                                <a href="{{ route('admin.orders.index') }}" class="text-desert-clay hover:underline">
                                    Lihat semua notifikasi
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <p class="font-medium text-forest-green">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-r from-rum-punch to-desert-clay rounded-full flex items-center justify-center text-white">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Content -->
        <div class="p-6">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg border border-green-300 flex items-center">
                    <i class="fas fa-check-circle mr-3 text-green-500"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg border border-red-300 flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle sidebar on mobile
            const sidebarToggle = document.createElement('button');
            sidebarToggle.innerHTML = '<i class="fas fa-bars"></i>';
            sidebarToggle.className = 'lg:hidden fixed top-4 left-4 z-50 bg-rum-punch text-white p-2 rounded-lg';
            document.body.appendChild(sidebarToggle);
            
            sidebarToggle.addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                const mainContent = document.querySelector('.main-content');
                
                sidebar.classList.toggle('-translate-x-full');
                mainContent.classList.toggle('ml-0');
            });
            
            // Auto-hide notifications after 5 seconds
            setTimeout(() => {
                const successAlert = document.querySelector('.bg-green-100');
                const errorAlert = document.querySelector('.bg-red-100');
                
                if (successAlert) {
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 300);
                }
                
                if (errorAlert) {
                    errorAlert.style.opacity = '0';
                    setTimeout(() => errorAlert.remove(), 300);
                }
            }, 5000);
        });
    </script>
</body>
</html>