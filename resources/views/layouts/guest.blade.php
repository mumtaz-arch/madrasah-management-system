<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - PONSPES System</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .font-heading { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary-600/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-gold-500/10 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col justify-center px-16 text-white">
                <div class="mb-8">
                    <img src="{{ asset('img/logo-ponpes.png') }}" alt="Logo Pondok Pesantren" class="w-16 h-16 rounded-2xl object-contain bg-white p-2 mb-6">
                    <h1 class="font-heading text-4xl font-bold mb-4">PONSPES System</h1>
                    <p class="text-xl text-white/80 mb-8">Sistem Manajemen Pondok Pesantren Terintegrasi</p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg">Aman & Terpercaya</h3>
                            <p class="text-white/70 text-sm">Data santri dan akademik terjaga dengan sistem keamanan modern</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg">Cepat & Efisien</h3>
                            <p class="text-white/70 text-sm">Kelola data, nilai, jadwal dalam satu platform terintegrasi</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg">Mudah Digunakan</h3>
                            <p class="text-white/70 text-sm">Interface intuitif untuk admin, guru, santri, dan wali</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <img src="{{ asset('img/logo-ponpes.png') }}" alt="Logo Pondok Pesantren" class="w-16 h-16 rounded-2xl object-contain bg-primary-600 p-2 mx-auto mb-4">
                    <h1 class="font-heading text-2xl font-bold text-gray-900">PONSPES System</h1>
                </div>
                
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
                    <div class="text-center mb-8">
                        <h2 class="font-heading text-2xl font-bold text-gray-900">Selamat Datang</h2>
                        <p class="text-gray-500 mt-2">Silakan login untuk melanjutkan</p>
                    </div>
                    
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                   placeholder="email@example.com">
                        </div>
                        
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input id="password" type="password" name="password" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                   placeholder="••••••••">
                        </div>
                        
                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-700">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-3 px-6 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                            Login
                        </button>
                    </form>
                    
                    <div class="mt-6 text-center">
                        <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-primary-600">
                            ← Kembali ke Halaman Utama
                        </a>
                    </div>
                </div>
                
                <!-- Footer -->
                <p class="text-center text-sm text-gray-500 mt-8">
                    © {{ date('Y') }} PONSPES System. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
