@extends('layouts.admin')

@section('title', 'Detail Order')
@section('icon', 'eye')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-forest-green">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
                <p class="text-gray-600">Detail order dan informasi customer</p>
            </div>
            
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="{{ route('admin.orders.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-cream text-forest-green rounded-lg hover:bg-olive transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                
                @if($order->status === 'pending')
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="paid">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition"
                                onclick="return confirm('Konfirmasi pembayaran order ini?')">
                            <i class="fas fa-check mr-2"></i> Konfirmasi Pembayaran
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Order Details -->
        <div class="lg:col-span-2">
            <!-- Order Status -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-forest-green mb-4 flex items-center">
                    <i class="fas fa-info-circle text-desert-clay mr-2"></i> Status Order
                </h3>
                
                <div class="space-y-4">
                    <!-- Status Badge -->
                    <div>
                        @if($order->status === 'pending')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-2"></i> Menunggu Pembayaran
                            </span>
                        @elseif($order->status === 'paid')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-2"></i> Dibayar
                            </span>
                        @elseif($order->status === 'cancelled')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times mr-2"></i> Dibatalkan
                            </span>
                        @endif
                    </div>
                    
                    <!-- Update Status Form -->
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        @method('PUT')
                        
                        <label class="text-sm font-medium text-gray-700">Ubah Status:</label>
                        
                        <select name="status" class="border border-gray-300 rounded-lg px-3 py-1">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        
                        <button type="submit" 
                                class="px-4 py-1 bg-desert-clay text-white rounded-lg hover:opacity-90 transition">
                            Update
                        </button>
                    </form>
                    
                    <!-- Order Timeline -->
                    <div class="mt-6">
                        <h4 class="font-medium text-gray-700 mb-3">Timeline Order:</h4>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-shopping-cart text-green-500 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Order dibuat</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($order->status === 'paid')
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-check text-green-500 text-sm"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Pembayaran dikonfirmasi</p>
                                        <p class="text-xs text-gray-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-forest-green mb-6 flex items-center">
                    <i class="fas fa-boxes text-desert-clay mr-2"></i> Produk dalam Order
                </h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <div class="h-12 w-12 bg-gradient-to-br from-cream to-olive rounded-lg flex items-center justify-center">
                                                    @if($item->product->image)
                                                        <img src="{{ $item->product->image_url }}" 
                                                             alt="{{ $item->product->name }}"
                                                             class="h-full w-full object-cover rounded-lg">
                                                    @else
                                                        <i class="fas fa-paw text-white"></i>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-forest-green">{{ $item->product->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $item->product->category }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                    </td>
                                    
                                    <td class="px-4 py-4">
                                        <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                    </td>
                                    
                                    <td class="px-4 py-4">
                                        <div class="text-sm font-bold text-rum-punch">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Shipping Information -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-forest-green mb-4 flex items-center">
                    <i class="fas fa-truck text-desert-clay mr-2"></i> Informasi Pengiriman
                </h3>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Alamat Pengiriman:</p>
                            <p class="text-gray-900">{{ $order->shipping_address }}</p>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-700">Metode Pengiriman:</p>
                            <p class="text-gray-900">Reguler - Estimasi 3-5 hari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Customer & Payment -->
        <div class="space-y-6">
            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-forest-green mb-4 flex items-center">
                    <i class="fas fa-user text-desert-clay mr-2"></i> Informasi Customer
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-desert-clay to-rum-punch flex items-center justify-center text-white text-lg font-bold mr-4">
                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <div>
                            <p class="text-sm text-gray-500">Role</p>
                            <p class="font-medium">{{ $order->user->role }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Terdaftar sejak</p>
                            <p class="font-medium">{{ $order->user->created_at->format('d M Y') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-500">Total Order</p>
                            <p class="font-medium">{{ $order->user->orders->count() }}</p>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <a href="mailto:{{ $order->user->email }}" 
                           class="inline-flex items-center text-sm text-desert-clay hover:underline">
                            <i class="fas fa-envelope mr-2"></i> Kirim Email
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-forest-green mb-4 flex items-center">
                    <i class="fas fa-credit-card text-desert-clay mr-2"></i> Informasi Pembayaran
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Metode Pembayaran</p>
                        <p class="font-medium">
                            @if($order->payment_method === 'qris')
                                <i class="fas fa-qrcode text-green-500 mr-2"></i> QRIS
                            @elseif($order->payment_method === 'va')
                                <i class="fas fa-building text-blue-500 mr-2"></i> Virtual Account
                            @endif
                        </p>
                    </div>
                    
                    @if($order->va_number)
                        <div>
                            <p class="text-sm text-gray-500">Nomor Virtual Account</p>
                            <p class="font-medium text-lg">{{ $order->va_number }}</p>
                        </div>
                    @endif
                    
                    @if($order->qris_image)
                        <div>
                            <p class="text-sm text-gray-500 mb-2">QR Code</p>
                            <div class="bg-white p-2 border border-gray-200 rounded-lg flex justify-center">
                                <img src="{{ asset('storage/' . $order->qris_image) }}" 
                                     alt="QR Code" 
                                     class="w-32 h-32">
                            </div>
                        </div>
                    @endif
                    
                    <div class="pt-4 border-t border-gray-200">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mt-1">
                            <span class="text-sm text-gray-500">Ongkos Kirim</span>
                            <span class="font-medium text-green-600">Gratis</span>
                        </div>
                        <div class="flex justify-between mt-3 pt-3 border-t border-gray-200">
                            <span class="text-lg font-bold text-forest-green">Total</span>
                            <span class="text-xl font-bold text-rum-punch">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Actions -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-forest-green mb-4">Aksi Order</h3>
                
                <div class="space-y-3">
                    @if($order->status === 'pending')
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" 
                                    class="w-full text-center py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition"
                                    onclick="return confirm('Konfirmasi pembayaran order ini?')">
                                <i class="fas fa-check mr-2"></i> Konfirmasi Pembayaran
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" 
                                    class="w-full text-center py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                                    onclick="return confirm('Batalkan order ini?')">
                                <i class="fas fa-times mr-2"></i> Batalkan Order
                            </button>
                        </form>
                    @endif
                    
                    <a href="#" 
                       class="block w-full text-center py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        <i class="fas fa-print mr-2"></i> Cetak Invoice
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" 
                       class="block w-full text-center py-2 bg-cream text-forest-green rounded-lg hover:bg-olive transition">
                        <i class="fas fa-list mr-2"></i> Semua Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update status confirmation
        const statusForm = document.querySelector('form select[name="status"]');
        if (statusForm) {
            statusForm.addEventListener('change', function() {
                const newStatus = this.value;
                const currentStatus = "{{ $order->status }}";
                
                if (newStatus !== currentStatus) {
                    if (newStatus === 'cancelled') {
                        if (!confirm('Batalkan order ini?')) {
                            this.value = currentStatus;
                            return;
                        }
                    } else if (newStatus === 'paid') {
                        if (!confirm('Konfirmasi pembayaran order ini?')) {
                            this.value = currentStatus;
                            return;
                        }
                    }
                }
            });
        }
    });
</script>
@endsection