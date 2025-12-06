@extends('layouts.admin')

@section('title', 'Dashboard')
@section('icon', 'tachometer-alt')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Users</p>
                    <p class="text-3xl font-bold text-forest-green mt-1">{{ $stats['total_users'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>12% dari bulan lalu</span>
                </div>
            </div>
        </div>
        
        <!-- Total Products -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Produk</p>
                    <p class="text-3xl font-bold text-desert-clay mt-1">{{ $stats['total_products'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-box text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>5 produk baru</span>
                </div>
            </div>
        </div>
        
        <!-- Total Orders -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Order</p>
                    <p class="text-3xl font-bold text-rum-punch mt-1">{{ $stats['total_orders'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>8 order bulan ini</span>
                </div>
            </div>
        </div>
        
        <!-- Total Revenue -->
        <div class="stat-card">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>15% dari bulan lalu</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts & Recent Orders -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-forest-green flex items-center">
                        <i class="fas fa-history text-desert-clay mr-2"></i> Order Terbaru
                    </h2>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-desert-clay hover:underline">
                        Lihat Semua
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <span class="font-medium text-forest-green">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div>{{ $order->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="px-4 py-3 font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        @if($order->status === 'pending')
                                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($order->status === 'paid')
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                Paid
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                                Cancelled
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('admin.orders.show', $order) }}" 
                                           class="text-desert-clay hover:text-rum-punch">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                        <i class="fas fa-box-open text-3xl mb-2"></i>
                                        <p>Belum ada order</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Notifications & Quick Actions -->
        <div class="space-y-6">
            <!-- Notifications -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-forest-green mb-4 flex items-center">
                    <i class="fas fa-bell text-desert-clay mr-2"></i> Notifikasi
                    @if($stats['unread_notifications'] > 0)
                        <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $stats['unread_notifications'] }} baru
                        </span>
                    @endif
                </h2>
                
                <div class="space-y-4 max-h-64 overflow-y-auto">
                    @forelse($notifications as $notification)
                        <div class="p-3 rounded-lg {{ $notification->is_read ? 'bg-gray-50' : 'bg-blue-50' }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    @if($notification->type === 'order_paid')
                                        <i class="fas fa-money-bill-wave text-green-500"></i>
                                    @else
                                        <i class="fas fa-info-circle text-blue-500"></i>
                                    @endif
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $notification->data['message'] ?? 'Notifikasi' }}</p>
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
                    @empty
                        <div class="text-center py-4 text-gray-500">
                            <i class="fas fa-bell-slash text-2xl mb-2"></i>
                            <p>Tidak ada notifikasi</p>
                        </div>
                    @endforelse
                </div>
                
                @if($stats['unread_notifications'] > 0)
                    <div class="mt-4">
                        <form action="{{ route('admin.notifications.read-all') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 text-center bg-cream text-forest-green rounded-lg hover:bg-olive transition">
                                Tandai Semua Dibaca
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold text-forest-green mb-4 flex items-center">
                    <i class="fas fa-bolt text-desert-clay mr-2"></i> Quick Actions
                </h2>
                
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.products.create') }}" 
                       class="p-4 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-lg text-center hover:shadow-md transition">
                        <i class="fas fa-plus text-green-500 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-green-800">Tambah Produk</p>
                    </a>
                    
                    <a href="{{ route('admin.settings.index') }}" 
                       class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg text-center hover:shadow-md transition">
                        <i class="fas fa-cog text-blue-500 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-blue-800">Pengaturan</p>
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" 
                       class="p-4 bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-lg text-center hover:shadow-md transition">
                        <i class="fas fa-shopping-cart text-purple-500 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-purple-800">Kelola Order</p>
                    </a>
                    
                    <a href="/" target="_blank" 
                       class="p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-lg text-center hover:shadow-md transition">
                        <i class="fas fa-external-link-alt text-yellow-500 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-yellow-800">Lihat Website</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- System Status -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold text-forest-green mb-6 flex items-center">
            <i class="fas fa-server text-desert-clay mr-2"></i> Status Sistem
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 border border-green-200 rounded-lg bg-green-50">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-green-800">Database</p>
                        <p class="text-sm text-green-600">Normal</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 border border-blue-200 rounded-lg bg-blue-50">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-blue-800">Storage</p>
                        <p class="text-sm text-blue-600">85% tersedia</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 border border-green-200 rounded-lg bg-green-50">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-green-800">API</p>
                        <p class="text-sm text-green-600">Aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh notifications
        setInterval(() => {
            fetch('/admin/dashboard')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newNotificationCount = doc.querySelector('.notification-badge')?.textContent || '0';
                    const currentNotificationCount = document.querySelector('.notification-badge')?.textContent || '0';
                    
                    if (newNotificationCount !== currentNotificationCount) {
                        location.reload();
                    }
                });
        }, 60000); // Check every minute
    });
</script>
@endsection