@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="flex justify-center">
                <div class="bg-gradient-to-r from-forest-green to-olive p-4 rounded-full">
                    <i class="fas fa-user-plus text-4xl text-white"></i>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 bunny-title">
                Buat Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Bergabung dengan komunitas BUNNYPOPS
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input id="name" name="name" type="text" autocomplete="name" required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-desert-clay focus:border-desert-clay sm:text-sm"
                           placeholder="Nama lengkap" value="{{ old('name') }}">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-desert-clay focus:border-desert-clay sm:text-sm"
                           placeholder="Email address" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password" required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-desert-clay focus:border-desert-clay sm:text-sm"
                           placeholder="Password (minimal 4 karakter)">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                           class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-desert-clay focus:border-desert-clay sm:text-sm"
                           placeholder="Ulangi password">
                </div>
            </div>

            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required 
                       class="h-4 w-4 text-desert-clay focus:ring-desert-clay border-gray-300 rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-900">
                    Saya setuju dengan 
                    <a href="#" class="text-desert-clay hover:text-rum-punch">Syarat & Ketentuan</a>
                    dan 
                    <a href="#" class="text-desert-clay hover:text-rum-punch">Kebijakan Privasi</a>
                </label>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-forest-green to-olive hover:from-forest-green hover:to-forest-green focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-olive transition-all duration-300">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus"></i>
                    </span>
                    Daftar Sekarang
                </button>
            </div>
            
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-desert-clay hover:text-rum-punch">
                        Login di sini
                    </a>
                </p>
            </div>
        </form>
        
        <div class="mt-6 p-4 bg-gradient-to-r from-rum-punch to-desert-clay rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-gift text-white mr-3 text-xl"></i>
                <div>
                    <p class="text-white text-sm font-medium">Bonus Pendaftaran!</p>
                    <p class="text-white text-xs">Dapatkan 10% diskon untuk pembelian pertama!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection