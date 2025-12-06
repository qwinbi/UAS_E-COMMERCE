@extends('layouts.app')

@section('title', 'Detail Order')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h1 class="bunny-title text-4xl font-bold text-forest-green mb-2">
                    <i class="fas fa-file-invoice text-desert-clay mr-2"></i> Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                </h1>
                <p class="text-gray-600">Detail order dan status pengiriman</p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <a href="{{ route('orders.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-cream text-forest-green rounded-lg hover:bg-olive transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
                </a>
            </div>
        </div>
    </div>
    
    <!-- Order Status Timeline -->
    <div class="bg-white rounded-bunny shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold text-forest-green mb-6 flex items-center">
            <i class="fas fa-truck text-desert-clay mr-2"></i> Status Order
        </h2>
        
        <div class="relative">
            <!-- Timeline -->
            <div class="flex items-center justify-between">
                @php
                    $steps = [
                        ['icon' => 'fa-shopping-cart', 'label' => 'Order Dibuat', 'date' => $order->created_at->format('d M'), 'active' => true],
                        ['icon' => 'fa-credit-card', 'label' => 'Pembayaran', 'date' => $order->status === 'paid' ? $order->updated_at->format('d M') : '', 'active' => $order->status === 'paid'],
                        ['icon' => 'fa-box', 'label' => 'Diproses', 'date' => '', 'active' => false],
                        ['icon' => 'fa-shipping-fast', 'label' => 'Dikirim', 'date' => '', 'active' => false],
                        ['icon' => 'fa-check-circle', 'label' => 'Selesai', 'date' => '', 'active' => false],
                    ];
                @endphp
                
                @foreach($steps as $index => $step)
                    <div class="flex flex-col items-center relative">
                        <!-- Step Circle -->
                        <div class="w-12 h-12 rounded-full flex items-center justify-center mb-2
                            {{ $step['active'] ? 'bg-desert-clay text-white' : 'bg-gray-200 text-gray-500' }}">
                            <i class="fas {{ $step['icon'] }}"></i>
                        </div>
                        
                        <!-- Step Label -->
                        <div class="text-center">
                            <p class="text-sm font-medium {{ $step['active'] ? 'text-desert-clay' : 'text-gray-500' }}">
                                {{ $step['label'] }}
                            </p>
                            @if($step['date'])
                                <p class="text-xs text-gray-500 mt-1">{{ $step['date'] }}</p>
                            @endif
                        </div>
                        
                        <!-- Connecting Line -->
                        @if($index < count($steps) - 1)
                            <div class="absolute top-6 left-1/2 w-full h-0.5 {{ $step['active'] ? 'bg-desert-clay' : 'bg-gray-300' }}"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Current Status -->
        <div class="mt-8 p-4 rounded-lg
            {{ $order->status === 'pending' ? 'bg-yellow-50 border border-yellow-200' : '' }}
            {{ $order->status === 'paid' ? 'bg-green-50 border border-green-200' : '' }}
            {{ $order->status === 'cancelled' ? 'bg-red-50 border border-red-200' : '' }}">
            <div class="flex items-center">
                @if($order->status === 'pending')
                    <i class="fas fa-clock text-yellow-500 text-2xl mr-3"></i>
                    <div>
                        <h4 class="font-bold text-yellow-800">Menunggu Pembayaran</h4>
                        <p class="text-yellow-700 text-sm">Selesaikan pembayaran untuk melanjutkan proses order</p>
                    </div>
                @elseif($order->status === 'paid')
                    <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                    <div>
                        <h4 class="font-bold text-green-800">Pembayaran Berhasil</h4>
                        <p class="text-green-700 text-sm">Order Anda sedang diproses oleh tim kami</p>
                    </div>
                @elseif($order->status === 'cancelled')
                    <i class="fas fa-times-circle text-red-500 text-2xl mr-3"></i>
                    <div>
                        <h4 class="font-bold text-red-800">Order Dibatalkan</h4>
                        <p class="text-red-700 text-sm">Order ini telah dibatalkan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Order Details -->
        <div class="lg:col-span-2">
            <!-- Order Items -->
            <div class="bg-white rounded-bunny shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-forest-green mb-6 flex items-center">
                    <i class="fas fa-boxes text-desert-clay mr-2"></i> Detail Produk
                </h2>
                
                <div class="space-y-6">
                    @foreach($order->items as $item)
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <!-- Product Image -->
                            <div class="w-20 h-20 bg-gradient-to-br from-cream to-olive rounded-lg flex items-center justify-center flex-shrink-0">
                                @if($item->product->image)
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                         class="w-full h-full object-cover rounded-lg">
                                @else
                                    <i class="fas fa-paw text-3xl text-white"></i>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="ml-4 flex-1">
                                <div class="flex justify-between">
                                    <div>
                                        <h4 class="font-bold text-lg text-forest-green">{{ $item->product->name }}</h4>
                                        <p class="text-gray-600 text-sm">{{ $item->product->category }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Harga Satuan</p>
                                        <p class="font-bold text-desert-clay">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center mt-2">
                                    <div class="flex items-center">
                                        <span class="text-gray-700">Jumlah: {{ $item->quantity }}</span>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Subtotal</p>
                                        <p class="text-lg font-bold text-rum-punch">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Shipping Address -->
            <div class="bg-white rounded-bunny shadow-lg p-6">
                <h2 class="text-xl font-bold text-forest-green mb-6 flex items-center">
                    <i class="fas fa-map-marker-alt text-desert-clay mr-2"></i> Alamat Pengiriman
                </h2>
                
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-user text-gray-500 mr-3 mt-1"></i>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ Auth::user()->name }}</h4>
                            <p class="text-gray-700 mt-2">{{ $order->shipping_address }}</p>
                            <div class="mt-3">
                                <p class="text-gray-600">
                                    <i class="fas fa-phone mr-2"></i> {{ Auth::user()->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Payment & Summary -->
        <div class="lg:col-span-1">
            <!-- Payment Information -->
            <div class="bg-white rounded-bunny shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-forest-green mb-6 flex items-center">
                    <i class="fas fa-credit-card text-desert-clay mr-2"></i> Informasi Pembayaran
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Metode Pembayaran</p>
                        <p class="font-bold text-forest-green">
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
                            <p class="font-bold text-lg text-rum-punch">{{ $order->va_number }}</p>
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-bold text-blue-800 text-sm mb-2">
                                <i class="fas fa-info-circle mr-1"></i> Instruksi Pembayaran
                            </h4>
                            <ol class="text-xs text-blue-700 list-decimal pl-4 space-y-1">
                                <li>Transfer ke nomor VA di atas</li>
                                <li>Gunakan bank yang tersedia</li>
                                <li>Pembayaran akan dikonfirmasi otomatis</li>
                                <li>Batas waktu: 24 jam</li>
                            </ol>
                        </div>
                    @endif
                    
                    @if($order->qris_image)
                        <div>
                            <p class="text-sm text-gray-500 mb-2">QR Code Pembayaran</p>
                            <div class="bg-white p-4 border border-gray-200 rounded-lg flex justify-center">
                                <img src="{{ asset('storage/' . $order->qris_image) }}" alt="QR Code" class="w-48 h-48">
                            </div>
                            <p class="text-xs text-gray-500 text-center mt-2">Scan QR code untuk membayar</p>
                        </div>
                    @endif
                    
                    @if($order->status === 'pending')
                        <div class="mt-6">
                            <a href="#" 
                               class="block w-full text-center py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:opacity-90 transition font-bold">
                                <i class="fas fa-external-link-alt mr-2"></i> Bayar Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="bg-white rounded-bunny shadow-lg p-6">
                <h2 class="text-xl font-bold text-forest-green mb-6 flex items-center">
                    <i class="fas fa-receipt text-desert-clay mr-2"></i> Ringkasan Order
                </h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
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
                            <span class="text-2xl font-bold text-rum-punch">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Order Details -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Order ID</span>
                            <span class="font-medium">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Order</span>
                            <span class="font-medium">{{ $order->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status Pembayaran</span>
                            <span class="font-medium {{ $order->status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $order->status === 'paid' ? 'Dibayar' : 'Menunggu' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="mt-6 space-y-3">
                    @if($order->status === 'pending')
                        <form action="#" method="POST" onsubmit="return confirm('Batalkan order ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:opacity-90 transition font-bold">
                                <i class="fas fa-times mr-2"></i> Batalkan Order
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('orders.index') }}" 
                       class="block w-full text-center py-3 bg-cream text-forest-green rounded-lg hover:bg-olive transition">
                        <i class="fas fa-list mr-2"></i> Lihat Semua Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-refresh for pending orders
        @if($order->status === 'pending')
            setTimeout(function() {
                location.reload();
            }, 30000); // Refresh every 30 seconds for pending orders
        
            // Show payment reminder
            const paymentReminder = document.createElement('div');
            paymentReminder.className = 'fixed bottom-4 right-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4 shadow-lg z-50 max-w-sm';
            paymentReminder.innerHTML = `
                <div class="flex items-start">
                    <i class="fas fa-clock text-yellow-500 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-bold text-yellow-800">Segera Selesaikan Pembayaran!</h4>
                        <p class="text-yellow-700 text-sm mt-1">Order akan otomatis dibatalkan dalam waktu 24 jam.</p>
                    </div>
                    <button class="ml-4 text-yellow-600 hover:text-yellow-800" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            document.body.appendChild(paymentReminder);
        @endif
    });
</script>
@endsection