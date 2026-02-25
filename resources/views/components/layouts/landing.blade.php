<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription ?? 'Pondok Pesantren Pancasila Reo - Madrasah Tsanawiyah An-Najah' }}">
    <title>{{ $title ?? 'Pondok Pesantren Pancasila Reo' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-4-rb.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Heroicons -->
    <script src="https://unpkg.com/@heroicons/v2.0.18/24/outline/index.js" defer></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        .font-heading { font-family: 'Outfit', sans-serif; }
        .font-sans { font-family: 'Inter', sans-serif; }
        
        /* Smooth scroll behavior */
        html { scroll-behavior: smooth; }
        
        /* Gradient backgrounds */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 50%, #388E3C 100%);
        }
        
        .bg-gradient-gold {
            background: linear-gradient(135deg, #D4AF37 0%, #B8962E 100%);
        }
        
        /* Text gradient */
        .text-gradient-primary {
            background: linear-gradient(135deg, #1B5E20, #4CAF50);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        /* Counter animation */
        .counter-animate {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ mobileMenuOpen: false, scrolled: false }" 
      @scroll.window="scrolled = window.scrollY > 50">
    
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
         :class="scrolled ? 'bg-white shadow-lg' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3">
                    <img src="{{ asset('img/logo-4-rb.png') }}" alt="Logo Ponpes Pancasila" class="w-12 h-12 rounded-full object-contain bg-white p-1">
                    <div>
                        <h1 class="font-heading font-bold text-lg" :class="scrolled ? 'text-primary-900' : 'text-white'">
                            Pancasila Reo
                        </h1>
                        <p class="text-xs" :class="scrolled ? 'text-gray-500' : 'text-white/70'">
                            Pondok Pesantren
                        </p>
                    </div>
                </a>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" class="font-medium transition-colors" 
                       :class="scrolled ? 'text-gray-700 hover:text-primary-600' : 'text-white/90 hover:text-white'">
                        Beranda
                    </a>
                    <a href="#tentang" class="font-medium transition-colors"
                       :class="scrolled ? 'text-gray-700 hover:text-primary-600' : 'text-white/90 hover:text-white'">
                        Tentang
                    </a>
                    <a href="#program" class="font-medium transition-colors"
                       :class="scrolled ? 'text-gray-700 hover:text-primary-600' : 'text-white/90 hover:text-white'">
                        Program
                    </a>
                    <a href="#guru" class="font-medium transition-colors"
                       :class="scrolled ? 'text-gray-700 hover:text-primary-600' : 'text-white/90 hover:text-white'">
                        Guru
                    </a>
                    <a href="#kontak" class="font-medium transition-colors"
                       :class="scrolled ? 'text-gray-700 hover:text-primary-600' : 'text-white/90 hover:text-white'">
                        Kontak
                    </a>
                    <a href="/ppdb" class="px-6 py-2.5 bg-gradient-gold text-white font-semibold rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                        Daftar PPDB
                    </a>
                    <a href="/login" class="px-5 py-2.5 border-2 rounded-full font-semibold transition-all"
                       :class="scrolled ? 'border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white' : 'border-white text-white hover:bg-white hover:text-primary-900'">
                        Login
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg"
                        :class="scrolled ? 'text-gray-700' : 'text-white'">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden bg-white shadow-xl border-t"
             x-cloak>
            <div class="px-4 py-6 space-y-4">
                <a href="#beranda" @click="mobileMenuOpen = false" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Beranda</a>
                <a href="#tentang" @click="mobileMenuOpen = false" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Tentang</a>
                <a href="#program" @click="mobileMenuOpen = false" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Program</a>
                <a href="#guru" @click="mobileMenuOpen = false" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Guru</a>
                <a href="#kontak" @click="mobileMenuOpen = false" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Kontak</a>
                <div class="pt-4 space-y-3">
                    <a href="/ppdb" class="block w-full text-center px-6 py-3 bg-gradient-gold text-white font-semibold rounded-full">
                        Daftar PPDB
                    </a>
                    <a href="/login" class="block w-full text-center px-6 py-3 border-2 border-primary-600 text-primary-600 font-semibold rounded-full">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- About -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="{{ asset('img/logo-4-rb.png') }}" alt="Logo Ponpes Pancasila" class="w-12 h-12 rounded-full object-contain bg-white p-1">
                        <div>
                            <h3 class="font-heading font-bold text-xl">Pancasila Reo</h3>
                            <p class="text-gray-400 text-sm">Pondok Pesantren</p>
                        </div>
                    </div>
                    <p class="text-gray-400 leading-relaxed mb-6">
                        Membentuk generasi Qurani yang berakhlak mulia, berwawasan luas, dan siap menghadapi tantangan zaman. 
                        Berdiri sejak 1995, kami telah meluluskan ribuan santri yang berkontribusi di berbagai bidang.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-heading font-bold text-lg mb-6">Tautan Cepat</h4>
                    <ul class="space-y-3">
                        <li><a href="#tentang" class="text-gray-400 hover:text-white transition-colors">Tentang Kami</a></li>
                        <li><a href="#program" class="text-gray-400 hover:text-white transition-colors">Program Unggulan</a></li>
                        <li><a href="#guru" class="text-gray-400 hover:text-white transition-colors">Profil Guru</a></li>
                        <li><a href="/ppdb" class="text-gray-400 hover:text-white transition-colors">Pendaftaran PPDB</a></li>
                        <li><a href="/login" class="text-gray-400 hover:text-white transition-colors">Portal Login</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-heading font-bold text-lg mb-6">Kontak Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-primary-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-gray-400">Jl. Pesantren No. 123, Kabupaten Bandung, Jawa Barat 40123</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span class="text-gray-400">(022) 1234567</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-primary-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-gray-400">info@nurulhidayah.sch.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">
                    © {{ date('Y') }} Pondok Pesantren Nurul Hidayah. All rights reserved.
                </p>
                <p class="text-gray-500 text-sm mt-2 md:mt-0">
                    Powered by <span class="text-primary-400">PONSPES System</span>
                </p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for animations -->
    <script>
        // Counter animation
        document.addEventListener('alpine:init', () => {
            Alpine.data('counter', (target) => ({
                count: 0,
                target: target,
                init() {
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                this.animateCounter();
                                observer.unobserve(entry.target);
                            }
                        });
                    });
                    observer.observe(this.$el);
                },
                animateCounter() {
                    const duration = 2000;
                    const steps = 60;
                    const increment = this.target / steps;
                    let current = 0;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= this.target) {
                            this.count = this.target;
                            clearInterval(timer);
                        } else {
                            this.count = Math.floor(current);
                        }
                    }, duration / steps);
                }
            }));
        });
    </script>
</body>
</html>
