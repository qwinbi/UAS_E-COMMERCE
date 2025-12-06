@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('icon', 'plus')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-forest-green">Tambah Produk Baru</h2>
        <p class="text-gray-600">Isi form berikut untuk menambahkan produk baru</p>
    </div>
    
    <!-- Form -->
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
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
                               placeholder="Contoh: Bunny Plush Toy"
                               value="{{ old('name') }}">
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
                                <option value="Toys" {{ old('category') == 'Toys' ? 'selected' : '' }}>Toys</option>
                                <option value="Accessories" {{ old('category') == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                                <option value="Clothing" {{ old('category') == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                                <option value="Home" {{ old('category') == 'Home' ? 'selected' : '' }}>Home</option>
                                <option value="Stationery" {{ old('category') == 'Stationery' ? 'selected' : '' }}>Stationery</option>
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
                                   placeholder="Contoh: 129000"
                                   value="{{ old('price') }}">
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
                               placeholder="Contoh: 50"
                               value="{{ old('stock') }}">
                        @error('stock')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" 
                                  rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                                  placeholder="Deskripsi produk...">{{ old('description') }}</textarea>
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
                    <!-- Image Upload -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-desert-clay transition">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                            <p class="text-sm text-gray-600 mb-2">Upload gambar produk</p>
                            <p class="text-xs text-gray-500 mb-4">Format: JPG, PNG, GIF (Max: 2MB)</p>
                            
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
                    
                    <!-- Image Preview -->
                    <div id="image-preview" class="hidden">
                        <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                        <div class="w-48 h-48 bg-gradient-to-br from-cream to-olive rounded-lg overflow-hidden">
                            <img id="preview" class="w-full h-full object-cover" alt="Preview">
                        </div>
                        <button type="button" 
                                onclick="removeImage()"
                                class="mt-2 text-sm text-red-600 hover:text-red-800">
                            <i class="fas fa-times mr-1"></i> Hapus Gambar
                        </button>
                    </div>
                    
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="pt-6 border-t border-gray-200">
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.products.index') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-desert-clay to-rum-punch text-white rounded-lg hover:opacity-90 transition">
                        <i class="fas fa-save mr-2"></i> Simpan Produk
                    </button>
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
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function removeImage() {
        const input = document.getElementById('image-upload');
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('image-preview');
        
        input.value = '';
        preview.src = '';
        previewContainer.classList.add('hidden');
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