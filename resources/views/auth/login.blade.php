@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="flex justify-center">
                <div class="bg-gradient-to-r from-rum-punch to-desert-clay p-4 rounded-full">
                    <i class="fas fa-paw text-4xl text-white"></i>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 bunny-title">
                Selamat Datang di BUNNYPOPS
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Silakan login ke akun Anda
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-desert-clay focus:border-desert-clay focus:z-10 sm:text-sm"
                           placeholder="Email address" value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-desert-clay focus:border-desert-clay focus:z-10 sm:text-sm"
                           placeholder="Password">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox" 
                           class="h-4 w-4 text-desert-clay focus:ring-desert-clay border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                        Ingat saya
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-desert-clay hover:text-rum-punch">
                        Lupa password?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-rum-punch to-desert-clay hover:from-rum-punch hover:to-rum-punch focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-desert-clay transition-all duration-300">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt"></i>
                    </span>
                    Login
                </button>
            </div>
            
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-desert-clay hover:text-rum-punch">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </form>
        
        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">
                        Atau login dengan
                    </span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3">
                <div>
                    <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fab fa-google text-red-500 mr-2"></i>
                        Google
                    </a>
                </div>
                <div>
                    <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fab fa-facebook text-blue-600 mr-2"></i>
                        Facebook
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-8 p-4 bg-gradient-to-r from-olive to-cream rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-forest-green mr-2"></i>
                <p class="text-sm text-forest-green">
                    <strong>Demo Credentials:</strong><br>
                    Admin: admin@email / 1234<br>
                    User: user@email.com / 4321
                </p>
            </div>
        </div>
    </div>
</div>
@endsection