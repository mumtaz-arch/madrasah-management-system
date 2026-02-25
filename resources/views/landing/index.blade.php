<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ \App\Models\LandingPageContent::where('key', 'hero_title')->value('value') ?? 'Pondok Pesantren Pancasila Reo' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-ponpes.png') }}">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased text-gray-800 bg-secondary-50 selection:bg-primary-200 selection:text-primary-900">

    <!-- Navbar (Sticky & Glassmorphism) -->
    <!-- Navbar (Clean & Sticky) -->
    <nav class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-6 h-20 flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                <img loading="lazy" src="{{ asset('img/logo-ponpes.png') }}" alt="Logo" class="h-10 w-auto">
                <div class="leading-tight">
                    <span class="block font-bold text-lg text-primary-900 tracking-tight">PONPES PANCASILA</span>
                    <span class="block text-[10px] font-semibold text-gray-500 uppercase tracking-widest">Reo - Manggarai</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8 font-medium text-gray-600">
                <a href="#beranda" class="text-sm hover:text-primary-600 transition-colors">Beranda</a>
                <a href="#tentang" class="text-sm hover:text-primary-600 transition-colors">Tentang</a>
                <a href="#program" class="text-sm hover:text-primary-600 transition-colors">Program</a>
                <a href="#guru" class="text-sm hover:text-primary-600 transition-colors">Asatidz</a>
                <a href="#kontak" class="text-sm hover:text-primary-600 transition-colors">Kontak</a>
            </div>

            <!-- CTA Buttons -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->id == 1)
                        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">
                        Masuk
                    </a>
                @endauth
                <a href="/ppdb" class="px-5 py-2.5 text-sm font-bold text-white bg-primary-600 rounded-lg hover:bg-primary-700 shadow-md shadow-primary-600/20 transition-all">
                    Daftar PPDB
                </a>
            </div>

            <!-- Mobile Toggle -->
            <button class="md:hidden text-gray-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </div>
    </nav>

    <!-- Hero Section (Clean & Focused) -->
    @php
        $heroTitle = \App\Models\LandingPageContent::where('key', 'hero_title')->value('value') ?? 'Mewujudkan Generasi Rabbani';
        $heroSubtitle = \App\Models\LandingPageContent::where('key', 'hero_subtitle')->value('value') ?? 'Pondok Pesantren Pancasila Reo mencetak kader ulama intelek yang berakhlak mulia dan berwawasan luas.';
        $heroImage = \App\Models\LandingPageContent::where('key', 'hero_image')->value('value');
        $heroBg = $heroImage ? asset('storage/'.$heroImage) : 'https://images.unsplash.com/photo-1564121211835-e88c852648ab?q=80&w=2070&auto=format&fit=crop';
    @endphp
    <section id="beranda" class="relative pt-32 pb-24 lg:pt-48 lg:pb-32 min-h-screen flex items-center">
        <!-- Background -->
        <div class="absolute inset-0 z-0">
            <img loading="lazy" src="{{ $heroBg }}" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gray-900/80"></div> <!-- Solid consistent dark overlay -->
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 backdrop-blur-md mb-8">
                <span class="w-2 h-2 rounded-full bg-green-400"></span>
                <span class="text-xs font-semibold text-white tracking-wider uppercase">Penerimaan Santri Baru 2026/2027</span>
            </div>

            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6 max-w-5xl mx-auto font-heading tracking-tight">
                {{ $heroTitle }}
            </h1>

            <p class="text-lg md:text-xl text-gray-200 mb-12 max-w-2xl mx-auto leading-relaxed">
                {{ $heroSubtitle }}
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="/ppdb" class="px-8 py-4 text-base font-bold text-white bg-primary-600 rounded-xl hover:bg-primary-500 shadow-lg shadow-primary-600/30 transition-all hover:-translate-y-1">
                    Daftar Sekarang
                </a>
                <a href="#program" class="px-8 py-4 text-base font-semibold text-white border border-white/30 rounded-xl hover:bg-white/10 transition-all">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section (Clean) -->
    <section class="relative z-20 -mt-16 px-6">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Stat Cards -->
                <div class="bg-white p-8 rounded-xl shadow-xl shadow-gray-200/50 border border-gray-100 flex flex-col items-center">
                    <span class="text-4xl font-bold text-primary-600 mb-2">1.2k+</span>
                    <span class="text-sm text-gray-500 font-medium uppercase tracking-wide">Alumni</span>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-xl shadow-gray-200/50 border border-gray-100 flex flex-col items-center">
                    <span class="text-4xl font-bold text-primary-600 mb-2">45+</span>
                    <span class="text-sm text-gray-500 font-medium uppercase tracking-wide">Pengajar</span>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-xl shadow-gray-200/50 border border-gray-100 flex flex-col items-center">
                    <span class="text-4xl font-bold text-primary-600 mb-2">100%</span>
                    <span class="text-sm text-gray-500 font-medium uppercase tracking-wide">Lulusan</span>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-xl shadow-gray-200/50 border border-gray-100 flex flex-col items-center">
                    <span class="text-4xl font-bold text-primary-600 mb-2">A</span>
                    <span class="text-sm text-gray-500 font-medium uppercase tracking-wide">Akreditasi</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Section (Clean Split) -->
    <section id="tentang" class="py-24 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <!-- Image Side -->
                <div class="relative">
                    @php
                        $aboutImage = \App\Models\LandingPageContent::where('key', 'about_image')->value('value');
                        $aboutUrl = $aboutImage ? asset('storage/'.$aboutImage) : 'https://images.unsplash.com/photo-1582298538104-fe2e74c2ed54?q=80&w=1974&auto=format&fit=crop';
                    @endphp
                    <img loading="lazy" src="{{ $aboutUrl }}" alt="Tentang Pesantren" class="rounded-2xl shadow-xl w-full object-cover aspect-[4/3] z-10 relative">
                    <!-- Decorative back blob -->
                    <div class="absolute -bottom-6 -right-6 w-2/3 h-2/3 bg-secondary-200 rounded-2xl -z-0"></div>
                </div>
                
                <!-- Text Side -->
                <div class="pl-0 md:pl-10">
                    <div class="inline-block px-3 py-1 rounded-full bg-primary-100 text-primary-700 font-bold text-xs uppercase tracking-widest mb-4">
                        Tentang Kami
                    </div>
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-6 font-heading leading-tight">
                        {{ \App\Models\LandingPageContent::where('key', 'about_title')->value('value') ?? 'Membangun Peradaban dengan Al-Qur\'an dan Sunnah' }}
                    </h2>
                    <div class="text-lg text-gray-600 mb-8 leading-relaxed font-light">
                        <p>
                             {{ \App\Models\LandingPageContent::where('key', 'about_text')->value('value') ?? 'Pondok Pesantren Pancasila Reo adalah lembaga pendidikan Islam modern yang memadukan kurikulum nasional dengan kurikulum pesantren salaf. Kami bertekad melahirkan generasi yang tidak hanya cerdas secara intelektual, tetapi juga memiliki kedalaman spiritual dan akhlak mulia.' }}
                        </p>
                    </div>
                    
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                            <span class="p-2 rounded-lg bg-primary-50 text-primary-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </span>
                            <span class="text-gray-800 font-semibold">Kurikulum Terpadu (Umum & Diniyah)</span>
                        </li>
                        <li class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                            <span class="p-2 rounded-lg bg-primary-50 text-primary-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </span>
                            <span class="text-gray-800 font-semibold">Program Tahfidzul Qur’an Intensif</span>
                        </li>
                    </ul>

                    <a href="#" class="inline-flex items-center font-bold text-primary-700 hover:text-primary-800 transition-colors group">
                        Selengkapnya
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Program Unggulan Section (Simple Grid) -->
    <section id="program" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-primary-600 font-bold tracking-widest uppercase text-xs mb-2 block">Program Pendidikan</span>
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-6 font-heading">Program Unggulan</h2>
                <p class="text-gray-500 text-lg font-light">
                    Dirancang khusus untuk menggali potensi santri dalam aspek akademik, spiritual, dan keterampilan.
                </p>
            </div>

            @php
                $programs = \App\Models\Program::where('is_featured', true)->orderBy('sort_order')->get();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($programs as $program)
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                        <div class="w-16 h-16 bg-primary-50 rounded-2xl flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-colors duration-300">
                             @if(Str::startsWith($program->icon, '<svg'))
                                {!! $program->icon !!}
                             @elseif(Str::startsWith($program->icon, 'fa-') || Str::startsWith($program->icon, 'fas '))
                                <i class="{{ $program->icon }} text-2xl"></i>
                             @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                             @endif
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $program->title }}</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            {{ Str::limit($program->description, 120) }}
                        </p>
                        <a href="#" class="text-primary-600 font-semibold text-sm hover:underline">Pelajari Detail &rarr;</a>
                    </div>
                @empty
                    <!-- Placeholders (Clean) -->
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-lg hover:shadow-xl transition-all hover:-translate-y-1 group">
                        <div class="w-16 h-16 bg-primary-50 rounded-2xl flex items-center justify-center text-primary-600 mb-6 group-hover:bg-primary-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Tahfidzul Qur'an</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Program unggulan menghafal Al-Qur'an 30 Juz dengan sanad bersambung.</p>
                        <a href="#" class="text-primary-600 font-semibold text-sm hover:underline">Pelajari Detail &rarr;</a>
                    </div>
                    <!-- More Placeholders... -->
                    <!-- Removed for brevity, loop handles real data -->
                @endforelse
            </div>
        </div>
    </section>

    <!-- Ayat / Quote Section (Serene & Focus) -->
    <section class="py-24 md:py-32 bg-primary-950 relative overflow-hidden text-center">
        <!-- Subtle Pattern -->
        <div class="absolute inset-0 opacity-5" style="background-image: url('https://www.transparenttextures.com/patterns/arabesque.png');"></div>
        <div class="container mx-auto px-6 relative z-10">
            <span class="text-secondary-500 font-serif text-6xl opacity-80 block mb-6 leading-none">&ldquo;</span>
            
            <p class="text-2xl md:text-5xl font-light text-white leading-relaxed mb-10 max-w-4xl mx-auto tracking-wide font-heading">
                "Barangsiapa yang menempuh suatu jalan untuk menuntut ilmu, maka Allah akan memudahkan baginya jalan menuju surga."
            </p>
            
            <div class="inline-flex items-center gap-4 border-t border-white/20 pt-6">
                <span class="text-gray-400 uppercase tracking-widest text-xs font-bold">Hadits Riwayat Muslim</span>
            </div>
        </div>
    </section>

    <!-- Prestasi Section (From Page Builder) -->
    @php
        $achievementsJson = \App\Models\LandingPageContent::where('key', 'achievements')->value('value') ?? '[]';
        $achievements = json_decode($achievementsJson, true) ?: [];
    @endphp
    
    @if(count($achievements) > 0)
    <section id="prestasi" class="py-24 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-primary-600 font-bold tracking-widest uppercase text-xs mb-2 block">Pencapaian</span>
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-6 font-heading">Prestasi Kami</h2>
                <p class="text-gray-500 text-lg font-light">
                    Berbagai pencapaian yang diraih santri dan pesantren dalam berbagai bidang.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($achievements as $achievement)
                    <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                        <p class="text-amber-600 font-bold text-sm mb-2">{{ $achievement['year'] ?? '' }}</p>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $achievement['title'] }}</h3>
                        @if(!empty($achievement['description']))
                            <p class="text-gray-600 leading-relaxed">{{ $achievement['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Testimoni Section (From Page Builder) -->
    @php
        $testimonialsJson = \App\Models\LandingPageContent::where('key', 'testimonials')->value('value') ?? '[]';
        $testimonials = json_decode($testimonialsJson, true) ?: [];
    @endphp
    
    @if(count($testimonials) > 0)
    <section id="testimoni" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-primary-600 font-bold tracking-widest uppercase text-xs mb-2 block">Testimoni</span>
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900 mb-6 font-heading">Kata Mereka</h2>
                <p class="text-gray-500 text-lg font-light">
                    Pengalaman dan kesan dari wali santri, alumni, dan masyarakat.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($testimonials as $testimonial)
                    <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 relative">
                        <svg class="w-10 h-10 text-primary-200 absolute top-6 right-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                        </svg>
                        <p class="text-gray-600 leading-relaxed mb-6 italic">"{{ $testimonial['text'] }}"</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-lg">
                                {{ strtoupper(substr($testimonial['name'], 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $testimonial['name'] }}</p>
                                <p class="text-primary-600 text-sm">{{ $testimonial['role'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Guru / Asatidz Section (From Page Builder) -->
    <section id="guru" class="py-24 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
                <div class="max-w-2xl">
                    <span class="text-primary-600 font-bold tracking-widest uppercase text-xs mb-2 block">Asatidz & Ustadzah</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-heading">Tim Pengajar Terbaik</h2>
                    <p class="text-gray-500 mt-4 text-lg">Dibimbing oleh tenaga pengajar alumni pesantren ternama dan lulusan perguruan tinggi terbaik.</p>
                </div>
                <a href="#" class="px-6 py-3 rounded-lg border border-gray-300 text-gray-700 font-semibold hover:bg-white hover:border-gray-400 transition-colors">
                    Lihat Semua Pengajar
                </a>
            </div>

            @php
                // Get selected guru IDs from Page Builder, fallback to is_featured
                $guruIdsJson = \App\Models\LandingPageContent::where('key', 'landing_guru_ids')->value('value') ?? '[]';
                $selectedGuruIds = json_decode($guruIdsJson, true) ?: [];
                
                if (count($selectedGuruIds) > 0) {
                    $gurus = \App\Models\Guru::whereIn('id', $selectedGuruIds)->get();
                } else {
                    $gurus = \App\Models\Guru::where('is_featured', true)->take(4)->get();
                }
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                @forelse($gurus as $guru)
                    <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="aspect-[3/4] overflow-hidden bg-gray-200 relative">
                             @if($guru->foto)
                                <img loading="lazy" src="{{ asset('storage/'.$guru->foto) }}" alt="{{ $guru->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                             @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                </div>
                             @endif
                        </div>
                        <div class="p-6 text-center">
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-primary-700 transition-colors">{{ $guru->nama }}</h4>
                            <p class="text-primary-600 text-sm font-medium mt-1 uppercase tracking-wide">{{ $guru->jabatan ?? 'Pengajar' }}</p>
                        </div>
                    </div>
                @empty
                     <!-- Placeholders -->
                     @foreach(range(1, 4) as $i)
                        <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                            <div class="aspect-[3/4] overflow-hidden bg-gray-100 relative flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                            <div class="p-6 text-center">
                                <h4 class="text-lg font-bold text-gray-900 group-hover:text-primary-700 transition-colors">Ustadz Fulan, S.Pd.I</h4>
                                <p class="text-primary-600 text-sm font-medium mt-1 uppercase tracking-wide">Pengajar Tahfizh</p>
                            </div>
                        </div>
                     @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <!-- Berita / Informasi (Clean Cards) -->
    <section id="berita" class="py-24 bg-white">
        <div class="container mx-auto px-6">
             <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
                <div class="max-w-2xl">
                    <span class="text-primary-600 font-bold tracking-widest uppercase text-xs mb-2 block">Informasi & Pengumuman</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 font-heading">Kabar Pesantren</h2>
                </div>
                <!-- Optional: Link to News Index if exists -->
            </div>

            @php
                // Try to fetch announcements if the table exists, else empty
                try {
                    $announcements = \App\Models\Announcement::latest()->take(3)->get();
                } catch (\Exception $e) {
                    $announcements = collect([]); 
                }
            @endphp
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @forelse($announcements as $news)
                    <article class="flex flex-col group cursor-pointer">
                        <div class="rounded-2xl overflow-hidden h-64 mb-6 relative shadow-sm border border-gray-100">
                             <!-- Fallback image if no image field -->
                            <img loading="lazy" src="https://images.unsplash.com/photo-1609599006353-e629aaabfeae?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="News">
                            <div class="absolute top-4 left-4 bg-white/95 backdrop-blur px-3 py-1.5 rounded-lg text-xs font-bold text-gray-900 shadow-sm border border-gray-100">
                                {{ $news->created_at->format('d M Y') }}
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-700 transition-colors leading-snug">
                            {{ $news->title }}
                        </h3>
                        <p class="text-gray-500 leading-relaxed mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($news->content), 120) }}
                        </p>
                        <span class="text-primary-600 font-semibold text-sm group-hover:underline mt-auto">Baca Selengkapnya &rarr;</span>
                    </article>
                @empty
                    <!-- News 1 (Fallback) -->
                    <article class="flex flex-col group cursor-pointer">
                        <div class="rounded-2xl overflow-hidden h-64 mb-6 relative shadow-sm border border-gray-100">
                            <img loading="lazy" src="https://images.unsplash.com/photo-1609599006353-e629aaabfeae?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="News">
                            <div class="absolute top-4 left-4 bg-white/95 backdrop-blur px-3 py-1.5 rounded-lg text-xs font-bold text-gray-900 shadow-sm border border-gray-100">
                                {{ date('d M Y') }}
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-700 transition-colors leading-snug">
                            Penerimaan Santri Baru Gelombang 1 Resmi Dibuka
                        </h3>
                        <p class="text-gray-500 leading-relaxed mb-4 line-clamp-3">
                            Alhamdulillah, pendaftaran santri baru untuk tahun ajaran 2026/2027 telah dibuka. Segera daftarkan putra-putri Anda sebelum kuota terpenuhi.
                        </p>
                        <span class="text-primary-600 font-semibold text-sm group-hover:underline mt-auto">Baca Selengkapnya &rarr;</span>
                    </article>

                    <!-- News 2 (Fallback) -->
                    <article class="flex flex-col group cursor-pointer">
                        <div class="rounded-2xl overflow-hidden h-64 mb-6 relative shadow-sm border border-gray-100">
                            <img loading="lazy" src="https://images.unsplash.com/photo-1577563908411-5077b6dc7624?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="News">
                            <div class="absolute top-4 left-4 bg-white/95 backdrop-blur px-3 py-1.5 rounded-lg text-xs font-bold text-gray-900 shadow-sm border border-gray-100">
                                05 JAN 2026
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-700 transition-colors leading-snug">
                            Kunjungan Syeikh dari Mesir ke Pondok Pesantren
                        </h3>
                        <p class="text-gray-500 leading-relaxed mb-4 line-clamp-3">
                            Kunjungan istimewa dalam rangka mempererat tali silaturahim dan berbagi ilmu seputar metode menghafal Al-Qur'an.
                        </p>
                        <span class="text-primary-600 font-semibold text-sm group-hover:underline mt-auto">Baca Selengkapnya &rarr;</span>
                    </article>

                    <!-- News 3 (Fallback) -->
                    <article class="flex flex-col group cursor-pointer">
                        <div class="rounded-2xl overflow-hidden h-64 mb-6 relative shadow-sm border border-gray-100">
                            <img loading="lazy" src="https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="News">
                            <div class="absolute top-4 left-4 bg-white/95 backdrop-blur px-3 py-1.5 rounded-lg text-xs font-bold text-gray-900 shadow-sm border border-gray-100">
                                28 DEC 2025
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-700 transition-colors leading-snug">
                            Prestasi Santri Juara 1 MTQ Tingkat Provinsi
                        </h3>
                        <p class="text-gray-500 leading-relaxed mb-4 line-clamp-3">
                            Selamat kepada Ananda Fulan bin Fulan yang telah berhasil meraih Juara 1 pada cabang Tilawatil Qur'an.
                        </p>
                        <span class="text-primary-600 font-semibold text-sm group-hover:underline mt-auto">Baca Selengkapnya &rarr;</span>
                    </article>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer (High Contrast & Clean) -->
    <footer class="bg-gray-900 text-white pt-20 pb-10 border-t border-gray-800">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- Branding -->
                <div class="col-span-1 md:col-span-1">
                     <a href="#" class="flex items-center gap-3 mb-6">
                        <img loading="lazy" src="{{ asset('img/logo-ponpes.png') }}" alt="Logo" class="h-10 w-auto bg-white rounded-full p-1">
                        <div class="leading-tight">
                            <span class="block font-bold text-lg text-white tracking-wide">PONPES PANCASILA</span>
                            <span class="block text-xs font-semibold text-gray-400 tracking-widest">REO - MANGGARAI</span>
                        </div>
                    </a>
                    <p class="text-gray-400 leading-relaxed text-sm mb-6">
                         {{ \App\Models\LandingPageContent::where('key', 'footer_text')->value('value') ?? 'Mewujudkan generasi Islam yang kaffah, berilmu, dan berakhlak mulia untuk kemajuan umat dan bangsa.' }}
                    </p>
                    <div class="flex gap-6">
                        <a href="{{ \App\Models\LandingPageContent::where('key', 'social_facebook')->value('value') ?? '#' }}" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary-600 text-gray-400 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="{{ \App\Models\LandingPageContent::where('key', 'social_instagram')->value('value') ?? '#' }}" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary-600 text-gray-400 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                         <a href="{{ \App\Models\LandingPageContent::where('key', 'social_youtube')->value('value') ?? '#' }}" class="w-12 h-12 rounded-full bg-gray-800 flex items-center justify-center hover:bg-primary-600 text-gray-400 hover:text-white transition-all">
                           <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Links 1 -->
                <div>
                    <h4 class="text-white font-bold uppercase tracking-widest text-xs mb-6">Tentang Kami</h4>
                    <ul class="space-y-4 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Profil Pondok</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Sejarah</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Visi & Misi</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Struktur Organisasi</a></li>
                    </ul>
                </div>

                <!-- Links 2 -->
                <div>
                    <h4 class="text-white font-bold uppercase tracking-widest text-xs mb-6">Pendidikan</h4>
                    <ul class="space-y-4 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-primary-400 transition-colors">KMI / Madrasah</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Tahfidzul Qur'an</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Ekstrakurikuler</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Kalender Akademik</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                   <h4 class="text-white font-bold uppercase tracking-widest text-xs mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-gray-400 text-sm">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ \App\Models\LandingPageContent::where('key', 'contact_address')->value('value') ?? 'Jl. Pesantren No. 1, Reo, Manggarai, NTT' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>(0385) 123456</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-primary-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>info@ponpespancasila.sch.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm text-center md:text-left">
                    &copy; {{ date('Y') }} Pondok Pesantren Pancasila Reo. All rights reserved.
                </p>
                <div class="flex gap-4">
                      <!-- Removed duplicate social icons -->
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>

