@extends('layouts.app')

@section('title', 'Riwayat Order')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="bunny-title text-4xl font-bold text-forest-green mb-2">
            <i class="fas fa-history text-desert-clay mr-2"></i> Riwayat Order
        </h1>
        <p class="text-gray-600">Lihat dan kelola semua order Anda</p>
    </div>
    
    @if($orders->isEmpty())
        <!-- Empty Orders -->
        <div class="bg-white rounded-bunny shadow-lg p-12 text-center">
            <div class="w-32 h-32 bg-gradient-to-br from-cream to-olive rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-box-open text-6xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-700 mb-4">Belum Ada Order</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">
                Anda belum membuat order apapun. Mulai belanja dan temukan produk lucu untuk Anda!
            </p>
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-desert-clay to-rum-punch text-white rounded-lg hover:opacity-90 transition">
                <i class="fas fa-shopping-bag mr-2"></i> Mulai Belanja
            </a>
        </div>
    @else
        <!-- Orders List -->
        <div class="bg-white rounded-bunny shadow-lg overflow-hidden">
            <!-- Orders Header -->
            <div class="bg-gradient-to-r from-cream to-olive p-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <h2 class="font-bold text-lg text-forest-green">
                        <i class="fas fa-clipboard-list mr-2"></i> {{ $orders->count() }} Order
                    </h2>
                    
                    <!-- Filter -->
                    <div class="flex items-center space-x-4 mt-2 md:mt-0">
                        <select class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:ring-desert-clay focus:border-desert-clay">
                            <option>Semua Status</option>
                            <option>Pending</option>
                            <option>Paid</option>
                            <option>Cancelled</option>
                        </select>
                        
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Cari order..." 
                                   class="border border-gray-300 rounded-lg pl-9 pr-3 py-1 text-sm focus:ring-desert-clay focus:border-desert-clay">
                            <i class="fas fa-search absolute left-3 top-2 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Orders Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                            <th class="px6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-forest-green">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-lg font-bold text-rum-punch">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($order->status === 'pending')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> Pending
                                        </span>
                                    @elseif($order->status === 'paid')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i> Paid
                                        </span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-1"></i> Cancelled
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($order->payment_method === 'qris')
                                            <i class="fas fa-qrcode text-green-500 mr-1"></i> QRIS
                                        @elseif($order->payment_method === 'va')
                                            <i class="fas fa-building text-blue-500 mr-1"></i> Virtual Account
                                        @endif
                                    </div>
                                    @if($order->va_number)
                                        <div class="text-xs text-gray-500">{{ $order->va_number }}</div>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('orders.show', $order) }}" 
                                       class="text-desert-clay hover:text-rum-punch mr-3">
                                        <i class="fas fa-eye mr-1"></i> Detail
                                    </a>
                                    
                                    @if($order->status === 'pending')
                                        <a href="#" 
                                           class="text-red-600 hover:text-red-900"
                                           onclick="return confirm('Batalkan order ini?')">
                                            <i class="fas fa-times mr-1"></i> Batalkan
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Orders Footer -->
            <div class="bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $orders->count() }}</span> dari {{ $orders->total() }} order
                    </div>
                    
                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="flex items-center space-x-2">
                            <a href="{{ $orders->previousPageUrl() }}" 
                               class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 {{ $orders->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            
                            <span class="text-sm text-gray-700">
                                Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}
                            </span>
                            
                            <a href="{{ $orders->nextPageUrl() }}" 
                               class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 {{ !$orders->hasMorePages() ? 'opacity-50 cursor-not-allowed' : '' }}">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-bunny p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-green-600 font-medium">Total Belanja</p>
                        <p class="text-2xl font-bold text-green-800 mt-1">
                            Rp {{ number_format($orders->where('status', 'paid')->sum('total_amount'), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-bunny p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-600 font-medium">Order Selesai</p>
                        <p class="text-2xl font-bold text-blue-800 mt-1">
                            {{ $orders->where('status', 'paid')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-bunny p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-yellow-600 font-medium">Menunggu Bayar</p>
                        <p class="text-2xl font-bold text-yellow-800 mt-1">
                            {{ $orders->where('status', 'pending')->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter orders by status
        const statusFilter = document.querySelector('select');
        if (statusFilter) {
            statusFilter.addEventListener('change', function() {
                const status = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    if (status === 'semua status') {
                        row.style.display = '';
                    } else {
                        const statusCell = row.querySelector('td:nth-child(4) span');
                        const rowStatus = statusCell.textContent.toLowerCase().trim();
                        
                        if (rowStatus.includes(status)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            });
        }
        
        // Search functionality
        const searchInput = document.querySelector('input[type="text"]');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const orderId = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                    const cells = row.querySelectorAll('td');
                    let found = false;
                    
                    cells.forEach(cell => {
                        if (cell.textContent.toLowerCase().includes(searchTerm)) {
                            found = true;
                        }
                    });
                    
                    if (found || searchTerm === '') {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection