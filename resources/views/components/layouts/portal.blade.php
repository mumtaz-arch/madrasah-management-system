@props(['title' => 'Portal', 'header' => '', 'role' => 'santri'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - PONSPES</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col" x-data="{ mobileNavOpen: false }">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route($role . '.dashboard') }}" class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center">
                                <span class="text-white font-bold text-sm">PP</span>
                            </div>
                            <div>
                                <span class="font-heading font-bold text-gray-900">PONSPES</span>
                                <span class="text-sm text-gray-500 ml-2">Portal {{ ucfirst($role) }}</span>
                            </div>
                        </a>
                    </div>
                    
                    <nav class="hidden md:flex items-center space-x-1">
                        @if($role === 'santri')
                            <a href="{{ route('santri.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('santri.dashboard') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('santri.cbt.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('santri.cbt.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                Ujian (CBT)
                            </a>
                        @elseif($role === 'guru')
                            <a href="{{ route('guru.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('guru.dashboard') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('guru.journal.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('guru.journal.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                Jurnal Mengajar
                            </a>
                            <a href="{{ route('guru.jadwal.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('guru.jadwal.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                Jadwal
                            </a>
                            <a href="{{ route('guru.nilai.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('guru.nilai.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                Input Nilai
                            </a>
                        @elseif($role === 'wali')
                            <a href="{{ route('wali.dashboard') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('wali.dashboard') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('wali.nilai.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('wali.nilai.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                Nilai
                            </a>
                            <a href="{{ route('wali.presensi.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('wali.presensi.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                Presensi
                            </a>
                            <a href="{{ route('wali.tagihan.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('wali.tagihan.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                Tagihan
                            </a>
                            <a href="{{ route('wali.chat.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('wali.chat.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                                Chat
                            </a>
                        @endif
                    </nav>
                    
                    <div class="flex items-center space-x-3">
                        <span class="hidden sm:block text-sm text-gray-600">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-red-600 transition-colors p-2 rounded-lg hover:bg-red-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                        <!-- Mobile Hamburger -->
                        <button @click="mobileNavOpen = !mobileNavOpen" class="md:hidden p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100">
                            <svg x-show="!mobileNavOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg x-show="mobileNavOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileNavOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-1"
             class="md:hidden bg-white border-b border-gray-200 shadow-lg"
             x-cloak
             @click.away="mobileNavOpen = false">
            <nav class="px-4 py-3 space-y-1">
                @if($role === 'santri')
                    <a href="{{ route('santri.dashboard') }}" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('santri.dashboard') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('santri.cbt.index') }}" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('santri.cbt.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Ujian (CBT)
                    </a>
                @elseif($role === 'guru')
                    <a href="{{ route('guru.dashboard') }}" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('guru.dashboard') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('guru.journal.index') }}" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('guru.journal.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Jurnal Mengajar
                    </a>
                    <a href="{{ route('guru.jadwal.index') }}" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('guru.jadwal.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Jadwal
                    </a>
                    <a href="{{ route('guru.nilai.index') }}" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('guru.nilai.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Input Nilai
                    </a>
                @elseif($role === 'wali')
                    <a href="{{ route('wali.dashboard') }}" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('wali.dashboard') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('wali.nilai.index') }}" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('wali.nilai.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Nilai
                    </a>
                    <a href="{{ route('wali.presensi.index') }}" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('wali.presensi.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Presensi
                    </a>
                    <a href="{{ route('wali.tagihan.index') }}" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('wali.tagihan.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Tagihan
                    </a>
                    <a href="{{ route('wali.chat.index') }}" class="block px-4 py-3 rounded-lg text-sm font-medium {{ request()->routeIs('wali.chat.*') ? 'bg-primary-100 text-primary-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Chat
                    </a>
                @endif
            </nav>
            <div class="px-4 py-3 border-t border-gray-100">
                <p class="text-sm text-gray-500">Login sebagai: <span class="font-medium text-gray-700">{{ Auth::user()->name }}</span></p>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 py-6 sm:py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-4 text-center text-gray-500 text-sm border-t border-gray-200 bg-white">
            <p>&copy; {{ date('Y') }} Pondok Pesantren. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
