@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('icon', 'box')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-forest-green">Kelola Produk</h2>
            <p class="text-gray-600">Kelola semua produk di BUNNYPOPS</p>
        </div>
        
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-desert-clay to-rum-punch text-white rounded-lg hover:opacity-90 transition">
                <i class="fas fa-plus mr-2"></i> Tambah Produk Baru
            </a>
        </div>
    </div>
    
    <!-- Filters & Search -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <input type="text" 
                       placeholder="Cari produk..." 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay">
            </div>
            
            <div>
                <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay">
                    <option value="">Semua Kategori</option>
                    <option value="Toys">Toys</option>
                    <option value="Accessories">Accessories</option>
                    <option value="Clothing">Clothing</option>
                    <option value="Home">Home</option>
                    <option value="Stationery">Stationery</option>
                </select>
            </div>
            
            <div>
                <select class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay">
                    <option value="">Semua Status Stok</option>
                    <option value="in_stock">Stok Tersedia</option>
                    <option value="low_stock">Stok Menipis</option>
                    <option value="out_of_stock">Stok Habis</option>
                </select>
            </div>
            
            <div>
                <button class="w-full px-4 py-2 bg-gradient-to-r from-olive to-forest-green text-white rounded-lg hover:opacity-90 transition">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </div>
        </div>
    </div>
    
    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 bg-gradient-to-br from-cream to-olive rounded-lg flex items-center justify-center">
                                            @if($product->image)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                                     class="h-full w-full object-cover rounded-lg">
                                            @else
                                                <i class="fas fa-paw text-white"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-forest-green">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($product->description, 30) }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                    {{ $product->category }}
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-rum-punch">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium">{{ $product->stock }}</div>
                                @if($product->stock < 10 && $product->stock > 0)
                                    <div class="text-xs text-yellow-600">Stok menipis!</div>
                                @elseif($product->stock == 0)
                                    <div class="text-xs text-red-600">Stok habis</div>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->stock > 0)
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i> Aktif
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times mr-1"></i> Nonaktif
                                    </span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Hapus produk ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                
                                <a href="{{ route('products.show', $product->slug) }}" 
                                   target="_blank"
                                   class="text-green-600 hover:text-green-900 ml-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-box-open text-4xl mb-4"></i>
                                    <p class="text-lg">Belum ada produk</p>
                                    <p class="text-sm mt-2">Mulai dengan menambahkan produk pertama Anda</p>
                                    <a href="{{ route('admin.products.create') }}" 
                                       class="inline-flex items-center mt-4 px-4 py-2 bg-desert-clay text-white rounded-lg hover:opacity-90 transition">
                                        <i class="fas fa-plus mr-2"></i> Tambah Produk
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
            <div class="bg-gray-50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} dari {{ $products->total() }} produk
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <a href="{{ $products->previousPageUrl() }}" 
                           class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 {{ $products->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        
                        <span class="text-sm text-gray-700">
                            Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                        </span>
                        
                        <a href="{{ $products->nextPageUrl() }}" 
                           class="px-3 py-1 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 {{ !$products->hasMorePages() ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-boxes text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-blue-600">Total Produk</p>
                    <p class="text-2xl font-bold text-blue-800">{{ $products->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-green-600">Produk Aktif</p>
                    <p class="text-2xl font-bold text-green-800">{{ $products->where('stock', '>', 0)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-yellow-600">Stok Menipis</p>
                    <p class="text-2xl font-bold text-yellow-800">{{ $products->where('stock', '<', 10)->where('stock', '>', 0)->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const searchInput = document.querySelector('input[type="text"]');
        const categorySelect = document.querySelector('select:nth-of-type(1)');
        const stockSelect = document.querySelector('select:nth-of-type(2)');
        const filterButton = document.querySelector('button');
        
        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const category = categorySelect.value;
            const stockStatus = stockSelect.value;
            
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                let showRow = true;
                
                // Search filter
                if (searchTerm) {
                    const productName = row.querySelector('td:nth-child(1) .text-forest-green').textContent.toLowerCase();
                    const productDesc = row.querySelector('td:nth-child(1) .text-gray-500').textContent.toLowerCase();
                    
                    if (!productName.includes(searchTerm) && !productDesc.includes(searchTerm)) {
                        showRow = false;
                    }
                }
                
                // Category filter
                if (category && showRow) {
                    const productCategory = row.querySelector('td:nth-child(2) span').textContent;
                    if (productCategory !== category) {
                        showRow = false;
                    }
                }
                
                // Stock filter
                if (stockStatus && showRow) {
                    const stockText = row.querySelector('td:nth-child(4) div:nth-child(1)').textContent;
                    const stock = parseInt(stockText);
                    
                    if (stockStatus === 'in_stock' && stock <= 0) {
                        showRow = false;
                    } else if (stockStatus === 'low_stock' && (stock >= 10 || stock <= 0)) {
                        showRow = false;
                    } else if (stockStatus === 'out_of_stock' && stock > 0) {
                        showRow = false;
                    }
                }
                
                row.style.display = showRow ? '' : 'none';
            });
        }
        
        searchInput.addEventListener('input', applyFilters);
        categorySelect.addEventListener('change', applyFilters);
        stockSelect.addEventListener('change', applyFilters);
        filterButton.addEventListener('click', applyFilters);
    });
</script>
@endsection