@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('icon', 'cog')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-forest-green">Pengaturan Aplikasi</h2>
        <p class="text-gray-600">Kelola pengaturan umum BUNNYPOPS</p>
    </div>
    
    <!-- Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="space-y-6">
            <!-- General Settings -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-forest-green mb-6 flex items-center">
                    <i class="fas fa-cog text-desert-clay mr-2"></i> Pengaturan Umum
                </h3>
                
                <div class="space-y-6">
                    <!-- Logo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">Logo Aplikasi</label>
                        
                        <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
                            <!-- Current Logo -->
                            <div>
                                <p class="text-sm text-gray-500 mb-2">Logo Saat Ini:</p>
                                <div class="w-32 h-32 bg-gradient-to-br from-cream to-olive rounded-lg overflow-hidden flex items-center justify-center">
                                    @if($settings['logo_path'] && $settings['logo_path'] !== 'logo/default-logo.png')
                                        <img src="{{ asset('storage/' . $settings['logo_path']) }}" 
                                             alt="Logo" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-paw text-6xl text-white"></i>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Upload New Logo -->
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 mb-2">Upload Logo Baru:</p>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-desert-clay transition">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-3"></i>
                                        <p class="text-sm text-gray-600 mb-2">Klik untuk upload logo baru</p>
                                        <p class="text-xs text-gray-500 mb-3">Format: JPG, PNG, GIF (Max: 2MB)</p>
                                        
                                        <input type="file" 
                                               name="logo" 
                                               id="logo-upload"
                                               accept="image/*"
                                               class="hidden"
                                               onchange="previewLogo(event)">
                                        
                                        <label for="logo-upload" 
                                               class="cursor-pointer px-4 py-2 bg-desert-clay text-white rounded-lg hover:opacity-90 transition">
                                            Pilih File
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Logo Preview -->
                                <div id="logo-preview" class="hidden mt-4">
                                    <p class="text-sm text-gray-500 mb-2">Preview:</p>
                                    <div class="w-32 h-32 bg-gradient-to-br from-cream to-olive rounded-lg overflow-hidden">
                                        <img id="logo-preview-img" class="w-full h-full object-cover" alt="Preview">
                                    </div>
                                    <button type="button" 
                                            onclick="removeLogo()"
                                            class="mt-2 text-sm text-red-600 hover:text-red-800">
                                        <i class="fas fa-times mr-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer Text -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teks Footer</label>
                        <textarea name="footer_text" 
                                  rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                                  placeholder="Teks yang akan ditampilkan di footer">{{ old('footer_text', $settings['footer_text']) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Teks ini akan ditampilkan di bagian footer website</p>
                    </div>
                    
                    <!-- About Text -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tentang Kami</label>
                        <textarea name="about_text" 
                                  rows="8"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-desert-clay focus:border-desert-clay"
                                  placeholder="Teks tentang perusahaan...">{{ old('about_text', $settings['about_text']) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Teks ini akan ditampilkan di halaman About</p>
                    </div>
                </div>
            </div>
            
            <!-- Payment Settings -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-forest-green mb-6 flex items-center">
                    <i class="fas fa-credit-card text-desert-clay mr-2"></i> Pengaturan Pembayaran
                </h3>
                
                <div class="space-y-6">
                    <!-- QRIS Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">QRIS Image</label>
                        
                        <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
                            <!-- Current QRIS -->
                            <div>
                                <p class="text-sm text-gray-500 mb-2">QRIS Saat Ini:</p>
                                @if($settings['qris_image_path'])
                                    <div class="w-48 h-48 bg-white border border-gray-300 rounded-lg p-4 flex items-center justify-center">
                                        <img src="{{ asset('storage/' . $settings['qris_image_path']) }}" 
                                             alt="QRIS" 
                                             class="w-full h-full object-contain">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">QRIS akan digunakan untuk pembayaran</p>
                                @else
                                    <div class="w-48 h-48 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center">
                                        <i class="fas fa-qrcode text-4xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-500">Belum ada QRIS</p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Upload New QRIS -->
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 mb-2">Upload QRIS Baru:</p>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-desert-clay transition">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-qrcode text-3xl text-gray-400 mb-3"></i>
                                        <p class="text-sm text-gray-600 mb-2">Upload gambar QR code untuk pembayaran QRIS</p>
                                        <p class="text-xs text-gray-500 mb-3">Format: JPG, PNG (Max: 2MB)</p>
                                        
                                        <input type="file" 
                                               name="qris_image" 
                                               id="qris-upload"
                                               accept="image/*"
                                               class="hidden"
                                               onchange="previewQRIS(event)">
                                        
                                        <label for="qris-upload" 
                                               class="cursor-pointer px-4 py-2 bg-green-500 text-white rounded-lg hover:opacity-90 transition">
                                            Pilih File QRIS
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- QRIS Preview -->
                                <div id="qris-preview" class="hidden mt-4">
                                    <p class="text-sm text-gray-500 mb-2">Preview QRIS Baru:</p>
                                    <div class="w-48 h-48 bg-white border border-gray-300 rounded-lg p-4">
                                        <img id="qris-preview-img" class="w-full h-full object-contain" alt="QRIS Preview">
                                    </div>
                                    <button type="button" 
                                            onclick="removeQRIS()"
                                            class="mt-2 text-sm text-red-600 hover:text-red-800">
                                        <i class="fas fa-times mr-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Instructions -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Instruksi Pembayaran</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="space-y-3">
                                <div>
                                    <p class="font-medium text-gray-700">QRIS:</p>
                                    <ol class="text-sm text-gray-600 list-decimal pl-5 mt-1 space-y-1">
                                        <li>Scan QR code yang ditampilkan</li>
                                        <li>Pilih bank/e-wallet Anda</li>
                                        <li>Konfirmasi pembayaran</li>
                                        <li>Sistem akan mengonfirmasi otomatis</li>
                                    </ol>
                                </div>
                                
                                <div>
                                    <p class="font-medium text-gray-700">Virtual Account:</p>
                                    <ol class="text-sm text-gray-600 list-decimal pl-5 mt-1 space-y-1">
                                        <li>Transfer ke nomor VA yang diberikan</li>
                                        <li>Gunakan bank yang tersedia</li>
                                        <li>Pembayaran akan dikonfirmasi otomatis</li>
                                        <li>Batas waktu: 24 jam</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- System Information -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-bold text-forest-green mb-6 flex items-center">
                    <i class="fas fa-info-circle text-desert-clay mr-2"></i> Informasi Sistem
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-700 mb-3">Versi Aplikasi</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">BUNNYPOPS</span>
                                <span class="text-sm font-medium">v1.0.0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Laravel</span>
                                <span class="text-sm font-medium">v{{ Illuminate\Foundation\Application::VERSION }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">PHP</span>
                                <span class="text-sm font-medium">v{{ PHP_VERSION }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-700 mb-3">Status Sistem</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Database</span>
                                <span class="text-sm font-medium text-green-600">Online</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Storage</span>
                                <span class="text-sm font-medium text-green-600">Normal</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Cache</span>
                                <span class="text-sm font-medium text-green-600">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-end space-x-4">
                    <button type="button" 
                            onclick="resetForm()"
                            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Reset
                    </button>
                    
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-desert-clay to-rum-punch text-white rounded-lg hover:opacity-90 transition">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewLogo(event) {
        const input = event.target;
        const preview = document.getElementById('logo-preview-img');
        const previewContainer = document.getElementById('logo-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function removeLogo() {
        const input = document.getElementById('logo-upload');
        const preview = document.getElementById('logo-preview-img');
        const previewContainer = document.getElementById('logo-preview');
        
        input.value = '';
        preview.src = '';
        previewContainer.classList.add('hidden');
    }
    
    function previewQRIS(event) {
        const input = event.target;
        const preview = document.getElementById('qris-preview-img');
        const previewContainer = document.getElementById('qris-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function removeQRIS() {
        const input = document.getElementById('qris-upload');
        const preview = document.getElementById('qris-preview-img');
        const previewContainer = document.getElementById('qris-preview');
        
        input.value = '';
        preview.src = '';
        previewContainer.classList.add('hidden');
    }
    
    function resetForm() {
        if (confirm('Reset semua perubahan?')) {
            location.reload();
        }
    }
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const logoInput = document.getElementById('logo-upload');
        const qrisInput = document.getElementById('qris-upload');
        
        // Check file sizes
        const maxSize = 2 * 1024 * 1024; // 2MB
        
        if (logoInput.files[0] && logoInput.files[0].size > maxSize) {
            e.preventDefault();
            alert('Ukuran file logo terlalu besar (max 2MB)');
            return false;
        }
        
        if (qrisInput.files[0] && qrisInput.files[0].size > maxSize) {
            e.preventDefault();
            alert('Ukuran file QRIS terlalu besar (max 2MB)');
            return false;
        }
        
        return true;
    });
</script>
@endsection