<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Panel' }} - PONSPES</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-4-rb.png') }}">
    
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#16a34a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="PONSPES">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <style>
        [x-cloak] { display: none !important; }
        .font-heading { font-family: 'Outfit', sans-serif; }
        
        /* Custom Scrollbar for Sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Prevent horizontal overflow globally */
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
        }

        /* Touch-friendly targets */
        @media (max-width: 767px) {
            .touch-target {
                min-height: 44px;
                min-width: 44px;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
    <div class="min-h-screen flex">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="fixed inset-0 z-40 bg-gray-900/60 backdrop-blur-sm lg:hidden"
             x-cloak></div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-primary-900 transform transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col"
               :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            
            <!-- Logo -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-primary-800">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('img/logo-4-rb.png') }}" alt="Logo Ponpes Pancasila" class="w-10 h-10 rounded-lg object-contain bg-white p-1">
                    <div>
                        <h1 class="font-heading font-bold text-white text-sm">PONSPES</h1>
                        <p class="text-primary-300 text-xs">Pancasila Reo</p>
                    </div>
                </div>
                <button @click="mobileMenuOpen = false" class="lg:hidden text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            
            <!-- Navigation (Scrollable with Scroll Persistence) -->
            <nav class="flex-1 overflow-y-auto sidebar-scroll px-4 py-4 space-y-1"
                 x-data="{ scrollPos: 0 }"
                 x-init="
                    // Restore scroll position on load
                    $nextTick(() => {
                        const saved = localStorage.getItem('sidebar-scroll');
                        if (saved) $el.scrollTop = parseInt(saved);
                    });
                    // Save scroll position on scroll
                    $el.addEventListener('scroll', () => {
                        localStorage.setItem('sidebar-scroll', $el.scrollTop);
                    });
                 ">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                
                <div class="pt-4" x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 text-xs font-semibold text-primary-500 uppercase tracking-wider hover:text-primary-400">
                        <span>Akademik</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-2 pl-2 space-y-1">
                
                        <a href="{{ route('admin.santri.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.santri.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <span>Data Santri</span>
                        </a>
                        
                        <a href="{{ route('admin.guru.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.guru.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Data Guru</span>
                        </a>
                        
                        <a href="{{ route('admin.kelas.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.kelas.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Data Kelas</span>
                        </a>
                        
                        <a href="{{ route('admin.mapel.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.mapel.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Mata Pelajaran</span>
                        </a>
                        
                        
                        <a href="{{ route('admin.jadwal.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.jadwal.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Jadwal Mengajar</span>
                        </a>

                        <a href="{{ route('admin.journal.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.journal.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Jurnal Mengajar</span>
                        </a>
                        
                        <a href="{{ route('admin.nilai.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.nilai.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Manajemen Nilai</span>
                        </a>
                        
                        <a href="{{ route('admin.rapor.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.rapor.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Rapor Digital</span>
                        </a>
                    </div>
                </div>
                
                <div class="pt-4" x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 text-xs font-semibold text-primary-500 uppercase tracking-wider hover:text-primary-400">
                        <span>Presensi</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-2 pl-2 space-y-1">
                        <a href="{{ route('admin.attendance.santri') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.attendance.santri') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            <span>Presensi Santri</span>
                        </a>
                        
                        <a href="{{ route('admin.attendance.guru') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.attendance.guru') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span>Presensi Guru</span>
                        </a>
                    </div>
                </div>
                
                <div class="pt-4" x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 text-xs font-semibold text-primary-500 uppercase tracking-wider hover:text-primary-400">
                        <span>PPDB</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-2 pl-2 space-y-1">
                        <a href="{{ route('admin.ppdb.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.ppdb.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Pendaftaran PPDB</span>
                        </a>
                    </div>
                </div>
                
                @if(auth()->user()->role === 'admin')
                <div class="pt-4" x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 text-xs font-semibold text-primary-500 uppercase tracking-wider hover:text-primary-400">
                        <span>CMS & Landing</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-2 pl-2 space-y-1">
                        <a href="{{ route('admin.announcements.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.announcements.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                            <span>Berita / Pengumuman</span>
                        </a>
                        
                        <a href="{{ route('admin.cms.page-builder') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.cms.page-builder') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/>
                            </svg>
                            <span>Page Builder</span>
                        </a>
                    </div>
                </div>
                @endif
                
                <div class="pt-4" x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 text-xs font-semibold text-primary-500 uppercase tracking-wider hover:text-primary-400">
                        <span>CBT Ujian</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-2 pl-2 space-y-1">
                        <a href="{{ route('admin.cbt.questions') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.cbt.questions') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Bank Soal</span>
                        </a>
                        
                        <a href="{{ route('admin.cbt.exams') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.cbt.exams') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Ujian</span>
                        </a>
                    </div>
                </div>
                
                <div class="pt-4" x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 text-xs font-semibold text-primary-500 uppercase tracking-wider hover:text-primary-400">
                        <span>Keuangan</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-2 pl-2 space-y-1">
                        <a href="{{ route('admin.finance.dashboard') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.finance.dashboard') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                        
                        <a href="{{ route('admin.finance.tagihan') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.finance.tagihan') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>Tagihan</span>
                        </a>
                        
                        <a href="{{ route('admin.finance.payments') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.finance.payments') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span>Pembayaran</span>
                        </a>
                        
                        <a href="{{ route('admin.finance.reports') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.finance.reports') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Laporan Keuangan</span>
                        </a>
                    </div>
                </div>
                
                <div class="pt-4" x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 text-xs font-semibold text-primary-500 uppercase tracking-wider hover:text-primary-400">
                        <span> Keuangan</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-2 pl-2 space-y-1">
                        <a href="{{ route('admin.analytics.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.analytics.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span>Analytics</span>
                        </a>
                       
                        <a href="{{ route('admin.export-data') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.export-data') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Export Data</span>
                        </a>
                    </div>
                </div>
                
                <div class="pt-4">
                    <p class="px-4 text-xs font-semibold text-primary-500 uppercase tracking-wider">AI Asisten</p>
                </div>
                
                <a href="{{ route('admin.ai.rpp') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.ai.rpp') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    <span>Generator RPP</span>
                </a>
                
                <a href="{{ route('admin.ai.questions') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.ai.questions') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Generator Soal</span>
                </a>
                
                <div class="pt-4" x-data="{ open: true }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 text-xs font-semibold text-primary-500 uppercase tracking-wider hover:text-primary-400">
                        <span>Pengaturan</span>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-2 pl-2 space-y-1">
                        <a href="{{ route('admin.settings.general') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.settings.general') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Pengaturan Umum</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" 
                           class="flex items-center space-x-3 px-4 py-2 rounded-lg transition-colors text-sm {{ request()->routeIs('admin.settings.index') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            <span>Sistem Sekolah</span>
                        </a>
                    </div>
                </div>
                
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Manajemen User</span>
                </a>
                
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.activity-logs') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.activity-logs') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span>Activity Logs</span>
                </a>
                
                <a href="{{ route('admin.backup.index') }}" 
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.backup.*') ? 'bg-primary-800 text-white' : 'text-primary-300 hover:bg-primary-800 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                    <span>Backup Database</span>
                </a>
                @endif
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 lg:ml-64 min-w-0">
            <!-- Top Navigation -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-30">
                <div class="flex items-center space-x-3 min-w-0">
                    <button @click="mobileMenuOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700 p-2 -ml-2 rounded-lg hover:bg-gray-100 touch-target flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h2 class="font-heading font-semibold text-gray-800 truncate">{{ $header ?? 'Dashboard' }}</h2>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- View Website Link -->
                    <a href="{{ url('/') }}" target="_blank" class="hidden md:flex items-center space-x-2 text-sm text-gray-500 hover:text-primary-600 font-medium bg-gray-50 px-3 py-2 rounded-lg border border-gray-200 hover:border-primary-300 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        <span>Lihat Website</span>
                    </a>

                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @php
                                $unreadNotifications = \App\Models\PpdbRegistration::where('status', 'pending')->count();
                                $recentPayments = \App\Models\Payment::whereDate('tanggal_bayar', today())->count();
                                $totalNotifications = $unreadNotifications + $recentPayments;
                            @endphp
                            @if($totalNotifications > 0)
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">{{ $totalNotifications > 9 ? '9+' : $totalNotifications }}</span>
                            @endif
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden z-50"
                             x-cloak>
                            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                                <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                                @if($totalNotifications > 0)
                                    <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full">{{ $totalNotifications }} baru</span>
                                @endif
                            </div>
                            
                            <div class="max-h-80 overflow-y-auto">
                                @if($unreadNotifications > 0)
                                    <a href="{{ route('admin.ppdb.index') }}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">Pendaftaran PPDB Baru</p>
                                                <p class="text-xs text-gray-500">{{ $unreadNotifications }} pendaftaran menunggu verifikasi</p>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                                
                                @if($recentPayments > 0)
                                    <a href="{{ route('admin.finance.payments') }}" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">Pembayaran Hari Ini</p>
                                                <p class="text-xs text-gray-500">{{ $recentPayments }} pembayaran diterima</p>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                                
                                @if($totalNotifications == 0)
                                    <div class="px-4 py-8 text-center">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                        </svg>
                                        <p class="text-gray-500 text-sm">Tidak ada notifikasi</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="px-4 py-2 bg-gray-50 border-t border-gray-200">
                                <a href="{{ route('admin.dashboard') }}" class="block text-center text-sm text-primary-600 hover:text-primary-700 font-medium">
                                    Lihat Semua
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 text-gray-700 hover:text-gray-900">
                            <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white font-semibold text-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden sm:block font-medium">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2"
                             x-cloak>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Profil Saya
                            </a>
                            <hr class="my-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
    
    @livewireScripts
    @stack('scripts')
    
    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('SW registered:', registration.scope);
                    })
                    .catch(error => {
                        console.log('SW registration failed:', error);
                    });
            });
        }
    </script>
</body>
</html>

