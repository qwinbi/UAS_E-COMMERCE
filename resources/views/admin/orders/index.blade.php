@extends('layouts.admin')

@section('title', 'Kelola Order')
@section('icon', 'shopping-cart')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-forest-green">Kelola Order</h2>
            <p class="text-gray-600">Kelola semua order pelanggan</p>
        </div>
        
        <div class="mt-4 md:mt-0 flex items-center space-x-4">
            <div class="relative">
                <input type="text" 
                       placeholder="Cari order..." 
                       class="border border-gray-300 rounded-lg px-4 py-2 pl-10 focus:ring-desert-clay focus:border-desert-clay">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
    </div>
    
    <!-- Stats Tabs -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Order</p>
                    <p class="text-2xl font-bold text-forest-green mt-1">{{ $orders->total() }}</p>
                </div>
                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $orders->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Paid</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $orders->where('status', 'paid')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Cancelled</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $orders->where('status', 'cancelled')->count() }}</p>
                </div>
                <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-times-circle text-white"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-forest-green">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-r from-desert-clay to-rum-punch flex items-center justify-center text-white">
                                            {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $order->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-rum-punch">
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
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                
                                @if($order->status === 'pending')
                                    <form action="{{ route('admin.orders.update-status', $order) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Konfirmasi pembayaran order ini?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="paid">
                                        <button type="submit" class="text-green-600 hover:text-green-900 mr-3">
                                            <i class="fas fa-check"></i> Konfirmasi
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.orders.update-status', $order) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Batalkan order ini?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-times"></i> Batalkan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-box-open text-4xl mb-4"></i>
                                    <p class="text-lg">Belum ada order</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari {{ $orders->total() }} order
                    </div>
                    
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
                </div>
            </div>
        @endif
    </div>
    
    <!-- Export & Actions -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-forest-green mb-2">Ekspor Data</h3>
                <p class="text-sm text-gray-600">Export data order dalam berbagai format</p>
            </div>
            
            <div class="flex space-x-4 mt-4 md:mt-0">
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-file-excel text-green-500 mr-2"></i> Excel
                </button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-file-pdf text-red-500 mr-2"></i> PDF
                </button>
                <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-file-csv text-blue-500 mr-2"></i> CSV
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.querySelector('input[type="text"]');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const orderId = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                    const customerName = row.querySelector('td:nth-child(2) .text-gray-900').textContent.toLowerCase();
                    const customerEmail = row.querySelector('td:nth-child(2) .text-gray-500').textContent.toLowerCase();
                    const paymentMethod = row.querySelector('td:nth-child(6)').textContent.toLowerCase();
                    
                    if (orderId.includes(searchTerm) || 
                        customerName.includes(searchTerm) || 
                        customerEmail.includes(searchTerm) ||
                        paymentMethod.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
        
        // Status filter buttons (if added)
        const statusButtons = document.querySelectorAll('.status-filter');
        if (statusButtons.length > 0) {
            statusButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const status = this.dataset.status;
                    const rows = document.querySelectorAll('tbody tr');
                    
                    rows.forEach(row => {
                        if (status === 'all') {
                            row.style.display = '';
                        } else {
                            const statusCell = row.querySelector('td:nth-child(5) span');
                            const rowStatus = statusCell.textContent.toLowerCase().trim();
                            
                            if (rowStatus.includes(status)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });
                });
            });
        }
    });
</script>
@endsection