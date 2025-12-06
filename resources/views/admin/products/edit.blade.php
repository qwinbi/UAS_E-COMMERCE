@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('icon', 'edit')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-forest-green">Edit Produk</h2>
                <p class="text-gray-600">Update informasi produk: {{ $product->name }}</p>
            </div>
            
            <div class="mt-4 md:mt-0">
                <a href="{{ route('admin.products.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-cream text-forest-green rounded-lg hover:bg-olive transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    
    <!-- Form -->
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-lg shadow-lg p-6 space-y-6">
            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-bold text-forest-green mb-4 flex items-center">
                    <i class="fas fa-info-circle text-desert-clay mr-2"></i> Informasi Dasar
                </h3>
                
                <div class="space-y-4">
                    <!-- Product Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Produk *</label>
                        <input type="text" 
                               name="name" 
                               required
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                               value="{{ old('name', $product->name) }}">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Category & Price -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                            <select name="category" 
                                    required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay">
                                <option value="">Pilih Kategori</option>
                                <option value="Toys" {{ old('category', $product->category) == 'Toys' ? 'selected' : '' }}>Toys</option>
                                <option value="Accessories" {{ old('category', $product->category) == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                                <option value="Clothing" {{ old('category', $product->category) == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                                <option value="Home" {{ old('category', $product->category) == 'Home' ? 'selected' : '' }}>Home</option>
                                <option value="Stationery" {{ old('category', $product->category) == 'Stationery' ? 'selected' : '' }}>Stationery</option>
                            </select>
                            @error('category')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) *</label>
                            <input type="number" 
                                   name="price" 
                                   required
                                   min="0"
                                   step="100"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                                   value="{{ old('price', $product->price) }}">
                            @error('price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok *</label>
                        <input type="number" 
                               name="stock" 
                               required
                               min="0"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                               value="{{ old('stock', $product->stock) }}">
                        @error('stock')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" 
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Product Image -->
            <div>
                <h3 class="text-lg font-bold text-forest-green mb-4 flex items-center">
                    <i class="fas fa-image text-desert-clay mr-2"></i> Gambar Produk
                </h3>
                
                <div class="space-y-4">
                    <!-- Current Image -->
                    <div id="current-image">
                        <p class="text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini:</p>
                        <div class="flex items-center space-x-4">
                            <div class="w-48 h-48 bg-gradient-to-br from-cream to-olive rounded-lg overflow-hidden">
                                @if($product->image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-paw text-6xl text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">
                                <p>Upload gambar baru untuk mengganti gambar saat ini.</p>
                                <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG, GIF (Max: 2MB)</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- New Image Upload -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-desert-clay transition">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                            <p class="text-sm text-gray-600 mb-2">Upload gambar baru</p>
                            <p class="text-xs text-gray-500 mb-4">Kosongkan jika tidak ingin mengganti gambar</p>
                            
                            <input type="file" 
                                   name="image" 
                                   id="image-upload"
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewImage(event)">
                            
                            <label for="image-upload" 
                                   class="cursor-pointer px-4 py-2 bg-desert-clay text-white rounded-lg hover:opacity-90 transition">
                                Pilih File
                            </label>
                        </div>
                    </div>
                    
                    <!-- New Image Preview -->
                    <div id="image-preview" class="hidden">
                        <p class="text-sm font-medium text-gray-700 mb-2">Preview Gambar Baru:</p>
                        <div class="flex items-center space-x-4">
                            <div class="w-48 h-48 bg-gradient-to-br from-cream to-olive rounded-lg overflow-hidden">
                                <img id="preview" class="w-full h-full object-cover" alt="Preview">
                            </div>
                            <div>
                                <button type="button" 
                                        onclick="removeImage()"
                                        class="text-sm text-red-600 hover:text-red-800">
                                    <i class="fas fa-times mr-1"></i> Hapus Gambar Baru
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-700 mb-2">Informasi Produk</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">ID Produk</p>
                        <p class="font-medium">{{ $product->id }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Slug</p>
                        <p class="font-medium">{{ $product->slug }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Dibuat</p>
                        <p class="font-medium">{{ $product->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Diupdate</p>
                        <p class="font-medium">{{ $product->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="pt-6 border-t border-gray-200">
                <div class="flex justify-between">
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" 
                          onsubmit="return confirm('Hapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i> Hapus Produk
                        </button>
                    </form>
                    
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.products.index') }}" 
                           class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </a>
                        
                        <button type="submit" 
                                class="px-6 py-2 bg-gradient-to-r from-desert-clay to-rum-punch text-white rounded-lg hover:opacity-90 transition">
                            <i class="fas fa-save mr-2"></i> Update Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('image-preview');
        const currentImage = document.getElementById('current-image');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                currentImage.classList.add('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function removeImage() {
        const input = document.getElementById('image-upload');
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('image-preview');
        const currentImage = document.getElementById('current-image');
        
        input.value = '';
        preview.src = '';
        previewContainer.classList.add('hidden');
        currentImage.classList.remove('hidden');
    }
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const price = document.querySelector('input[name="price"]');
        const stock = document.querySelector('input[name="stock"]');
        
        if (parseInt(price.value) < 0) {
            e.preventDefault();
            alert('Harga tidak boleh negatif');
            price.focus();
            return false;
        }
        
        if (parseInt(stock.value) < 0) {
            e.preventDefault();
            alert('Stok tidak boleh negatif');
            stock.focus();
            return false;
        }
        
        return true;
    });
</script>
@endsection