<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ \App\Models\LandingPageContent::where('key', 'hero_title')->value('value') ?? 'Pondok Pesantren Pancasila Reo' }}</title>
    <meta name="description" content="Pondok Pesantren Pancasila Reo - Mencetak generasi rabbani yang berilmu dan berakhlak mulia">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-ponpes.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .swiper-pagination-bullet-active { background: #FFC107 !important; }
        .swiper-pagination-bullet { background: #fff; opacity: 0.6; width: 12px; height: 12px; }
        .stat-number { transition: all 0.3s; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .delay-100 { animation-delay: 0.1s; } .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; } .delay-400 { animation-delay: 0.4s; }
        .hero-overlay { background: linear-gradient(180deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.85) 100%); }
        .green-gradient { background: linear-gradient(135deg, #065f46 0%, #078343 50%, #059669 100%); }
        .nav-scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    </style>
</head>
<body class="antialiased text-gray-800 bg-white">

@php
    $banners = \App\Models\Banner::active()->get();
    $heroTitle = \App\Models\LandingPageContent::where('key', 'hero_title')->value('value') ?? 'Mewujudkan Generasi Rabbani';
    $heroSubtitle = \App\Models\LandingPageContent::where('key', 'hero_subtitle')->value('value') ?? 'Pondok Pesantren Pancasila Reo mencetak kader ulama intelek yang berakhlak mulia dan berwawasan luas.';
    $heroImage = \App\Models\LandingPageContent::where('key', 'hero_image')->value('value');
    $heroBg = $heroImage ? asset('storage/'.$heroImage) : asset('img/dummy/hero-1.png');
    $visionText = \App\Models\LandingPageContent::where('key', 'vision_text')->value('value') ?? '"Wujudkan generasi islami berkarakter yang seimbang secara spiritual, intelektual, moral dan keterampilan, ber-tafaqquh fiddin sebagai kader umat yang rahmatan lil alamin."';
    $visionSubtext = \App\Models\LandingPageContent::where('key', 'vision_subtext')->value('value') ?? 'Visi Pondok Pesantren Pancasila Reo';
    $statSantri = \App\Models\LandingPageContent::where('key', 'stat_santri')->value('value') ?? '500+';
    $statAlumni = \App\Models\LandingPageContent::where('key', 'stat_alumni')->value('value') ?? '1.200+';
    $statPengajar = \App\Models\LandingPageContent::where('key', 'stat_pengajar')->value('value') ?? '45+';
    $statAkreditasi = \App\Models\LandingPageContent::where('key', 'stat_akreditasi')->value('value') ?? 'A';
    $aboutTitle = \App\Models\LandingPageContent::where('key', 'about_title')->value('value') ?? 'Membangun Peradaban dengan Al-Qur\'an dan Sunnah';
    $aboutText = \App\Models\LandingPageContent::where('key', 'about_text')->value('value') ?? 'Pondok Pesantren Pancasila Reo adalah lembaga pendidikan Islam modern yang memadukan kurikulum nasional dengan kurikulum pesantren salaf. Kami bertekad melahirkan generasi yang tidak hanya cerdas secara intelektual, tetapi juga memiliki kedalaman spiritual dan akhlak mulia.';
    $aboutImage = \App\Models\LandingPageContent::where('key', 'about_image')->value('value');
    $aboutUrl = $aboutImage ? asset('storage/'.$aboutImage) : asset('img/dummy/about.png');
    $programs = \App\Models\Program::where('is_featured', true)->orderBy('sort_order')->get();
    $achievementsJson = \App\Models\LandingPageContent::where('key', 'achievements')->value('value') ?? '[]';
    $achievements = json_decode($achievementsJson, true) ?: [];
    $testimonialsJson = \App\Models\LandingPageContent::where('key', 'testimonials')->value('value') ?? '[]';
    $testimonials = json_decode($testimonialsJson, true) ?: [];
    $guruIdsJson = \App\Models\LandingPageContent::where('key', 'landing_guru_ids')->value('value') ?? '[]';
    $selectedGuruIds = json_decode($guruIdsJson, true) ?: [];
    $gurus = count($selectedGuruIds) > 0 ? \App\Models\Guru::whereIn('id', $selectedGuruIds)->get() : \App\Models\Guru::where('is_featured', true)->take(4)->get();
    try { $announcements = \App\Models\Announcement::latest()->take(3)->get(); } catch (\Exception $e) { $announcements = collect([]); }
    $footerText = \App\Models\LandingPageContent::where('key', 'footer_text')->value('value') ?? 'Mewujudkan generasi Islam yang kaffah, berilmu, dan berakhlak mulia untuk kemajuan umat dan bangsa.';
    $mapEmbed = \App\Models\LandingPageContent::where('key', 'map_embed')->value('value') ?? '';
@endphp

<!-- Navbar -->
<nav id="mainNav" class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
    <div class="container mx-auto px-6 h-20 flex justify-between items-center">
        <a href="#" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
            <img loading="lazy" src="{{ asset('img/logo-ponpes.png') }}" alt="Logo" class="h-12 w-auto">
            <div class="leading-tight">
                <span class="block font-extrabold text-lg text-emerald-800 tracking-tight">PONPES PANCASILA</span>
                <span class="block text-[10px] font-semibold text-gray-500 uppercase tracking-[0.2em]">Reo - Manggarai</span>
            </div>
        </a>
        <div class="hidden lg:flex items-center gap-8 font-semibold text-gray-600 text-sm">
            <a href="#beranda" class="hover:text-emerald-700 transition-colors border-b-2 border-transparent hover:border-emerald-600 pb-1">Beranda</a>
            <a href="#tentang" class="hover:text-emerald-700 transition-colors border-b-2 border-transparent hover:border-emerald-600 pb-1">Profil</a>
            <a href="#program" class="hover:text-emerald-700 transition-colors border-b-2 border-transparent hover:border-emerald-600 pb-1">Program</a>
            <a href="#prestasi" class="hover:text-emerald-700 transition-colors border-b-2 border-transparent hover:border-emerald-600 pb-1">Prestasi</a>
            <a href="#guru" class="hover:text-emerald-700 transition-colors border-b-2 border-transparent hover:border-emerald-600 pb-1">Asatidz</a>
            <a href="#berita" class="hover:text-emerald-700 transition-colors border-b-2 border-transparent hover:border-emerald-600 pb-1">Berita</a>
            <a href="#kontak" class="hover:text-emerald-700 transition-colors border-b-2 border-transparent hover:border-emerald-600 pb-1">Kontak</a>
        </div>
        <div class="hidden lg:flex items-center gap-3">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all">Masuk</a>
            @endauth
            <a href="/ppdb" class="px-6 py-2.5 text-sm font-bold text-emerald-900 bg-yellow-400 rounded-lg hover:bg-yellow-300 shadow-md shadow-yellow-400/30 transition-all hover:-translate-y-0.5">Daftar PPDB</a>
        </div>
        <!-- Mobile Toggle -->
        <button id="mobileMenuBtn" class="lg:hidden text-gray-600 focus:outline-none p-2">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden lg:hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="container mx-auto px-6 py-4 space-y-3">
            <a href="#beranda" class="block py-2 text-gray-700 font-semibold hover:text-emerald-700">Beranda</a>
            <a href="#tentang" class="block py-2 text-gray-700 font-semibold hover:text-emerald-700">Profil</a>
            <a href="#program" class="block py-2 text-gray-700 font-semibold hover:text-emerald-700">Program</a>
            <a href="#prestasi" class="block py-2 text-gray-700 font-semibold hover:text-emerald-700">Prestasi</a>
            <a href="#guru" class="block py-2 text-gray-700 font-semibold hover:text-emerald-700">Asatidz</a>
            <a href="#berita" class="block py-2 text-gray-700 font-semibold hover:text-emerald-700">Berita</a>
            <a href="#kontak" class="block py-2 text-gray-700 font-semibold hover:text-emerald-700">Kontak</a>
            <hr class="my-2">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="block py-2 text-emerald-700 font-bold">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="block py-2 text-gray-700 font-semibold">Masuk</a>
            @endauth
            <a href="/ppdb" class="block py-3 text-center font-bold text-emerald-900 bg-yellow-400 rounded-lg hover:bg-yellow-300">Daftar PPDB</a>
        </div>
    </div>
</nav>

<!-- Hero Slider Section -->
<section id="beranda" class="pt-20">
    <div class="swiper heroSwiper w-full" style="height: 85vh; min-height: 500px;">
        <div class="swiper-wrapper">
            @if($banners->count() > 0)
                @foreach($banners as $banner)
                <div class="swiper-slide relative">
                    <img src="{{ $banner->image ? asset('storage/'.$banner->image) : $heroBg }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                    <div class="hero-overlay absolute inset-0"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center px-6 max-w-4xl animate-fade-in-up">
                            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-yellow-400 leading-tight mb-6 drop-shadow-lg">{{ $banner->title }}</h1>
                            @if($banner->subtitle)
                            <p class="text-lg md:text-xl text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed font-medium">{{ $banner->subtitle }}</p>
                            @endif
                            @if($banner->cta_text)
                            <a href="{{ $banner->cta_link ?? '/ppdb' }}" class="inline-block px-10 py-4 text-lg font-bold text-emerald-900 bg-yellow-400 rounded-xl hover:bg-yellow-300 shadow-xl shadow-yellow-400/30 transition-all hover:-translate-y-1 border-2 border-yellow-300">{{ $banner->cta_text }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Default slide when no banners -->
                <div class="swiper-slide relative">
                    <img src="{{ $heroBg }}" alt="Ponpes Pancasila Reo" class="w-full h-full object-cover">
                    <div class="hero-overlay absolute inset-0"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center px-6 max-w-4xl">
                            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-yellow-400 leading-tight mb-6 drop-shadow-lg">{{ $heroTitle }}</h1>
                            <p class="text-lg md:text-xl text-white/90 mb-10 max-w-2xl mx-auto leading-relaxed font-medium">{{ $heroSubtitle }}</p>
                            <a href="/ppdb" class="inline-block px-10 py-4 text-lg font-bold text-emerald-900 bg-yellow-400 rounded-xl hover:bg-yellow-300 shadow-xl shadow-yellow-400/30 transition-all hover:-translate-y-1 border-2 border-yellow-300">DAFTAR SANTRI BARU 2026/2027</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="swiper-pagination !bottom-8"></div>
    </div>
</section>

<!-- Vision / Quote Section -->
<section class="green-gradient py-20 md:py-28 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5" style="background-image: url('https://www.transparenttextures.com/patterns/arabesque.png');"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="relative hidden lg:block">
                <div class="grid grid-cols-2 gap-4">
                    <img src="{{ $aboutUrl }}" alt="Campus" class="rounded-2xl shadow-2xl w-full h-48 object-cover border-4 border-white/20 translate-y-6">
                    <img src="{{ $heroBg }}" alt="Campus" class="rounded-2xl shadow-2xl w-full h-48 object-cover border-4 border-white/20 -translate-y-2">
                </div>
                <div class="absolute -bottom-2 -left-2 w-8 h-8 bg-yellow-400 rounded-full opacity-80"></div>
                <div class="absolute top-0 right-8 w-5 h-5 bg-emerald-300 rounded-full opacity-60"></div>
            </div>
            <div class="text-center lg:text-left">
                <p class="text-2xl md:text-4xl font-bold text-white leading-relaxed italic mb-8">{{ $visionText }}</p>
                <div class="w-16 h-1 bg-yellow-400 mb-4 mx-auto lg:mx-0"></div>
                <p class="text-yellow-300 uppercase tracking-[0.2em] text-sm font-bold">{{ $visionSubtext }}</p>
                <a href="/ppdb" class="inline-block mt-8 px-8 py-4 text-base font-bold text-emerald-900 bg-white rounded-xl hover:bg-yellow-400 shadow-xl transition-all hover:-translate-y-1">DAFTAR SANTRI 2026/2027</a>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Counter Section -->
<section class="py-4 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 -mt-12 relative z-20">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all hover:-translate-y-1">
                <span class="text-4xl md:text-5xl font-extrabold text-yellow-500 block mb-2">{{ $statSantri }}</span>
                <span class="text-sm text-gray-600 font-semibold uppercase tracking-wider">Santri</span>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all hover:-translate-y-1">
                <span class="text-4xl md:text-5xl font-extrabold text-yellow-500 block mb-2">{{ $statAlumni }}</span>
                <span class="text-sm text-gray-600 font-semibold uppercase tracking-wider">Alumni</span>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all hover:-translate-y-1">
                <span class="text-4xl md:text-5xl font-extrabold text-yellow-500 block mb-2">{{ $statPengajar }}</span>
                <span class="text-sm text-gray-600 font-semibold uppercase tracking-wider">Pendidik</span>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all hover:-translate-y-1">
                <span class="text-4xl md:text-5xl font-extrabold text-yellow-500 block mb-2">{{ $statAkreditasi }}</span>
                <span class="text-sm text-gray-600 font-semibold uppercase tracking-wider">Akreditasi</span>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Section -->
<section id="tentang" class="py-24 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <img loading="lazy" src="{{ $aboutUrl }}" alt="Tentang Pesantren" class="rounded-2xl shadow-xl w-full object-cover aspect-[4/3] z-10 relative border-4 border-white">
                <div class="absolute -bottom-6 -right-6 w-2/3 h-2/3 green-gradient rounded-2xl -z-0 opacity-20"></div>
            </div>
            <div>
                <div class="inline-block px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs uppercase tracking-[0.15em] mb-4">Tentang Kami</div>
                <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">{{ $aboutTitle }}</h2>
                <p class="text-lg text-gray-600 mb-8 leading-relaxed">{{ $aboutText }}</p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                        <span class="p-3 rounded-xl bg-emerald-100 text-emerald-700"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></span>
                        <span class="text-gray-800 font-semibold">Kurikulum Terpadu (Umum & Diniyah)</span>
                    </li>
                    <li class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm border border-gray-100">
                        <span class="p-3 rounded-xl bg-emerald-100 text-emerald-700"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg></span>
                        <span class="text-gray-800 font-semibold">Program Tahfidzul Qur'an Intensif</span>
                    </li>
                </ul>
                <a href="#program" class="inline-flex items-center font-bold text-emerald-700 hover:text-emerald-800 transition-colors group text-lg">
                    Selengkapnya <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Program Unggulan Section -->
<section id="program" class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-emerald-700 font-bold tracking-[0.15em] uppercase text-xs mb-2 block">Program Pendidikan</span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6">Program Unggulan</h2>
            <p class="text-gray-500 text-lg">Dirancang khusus untuk menggali potensi santri dalam aspek akademik, spiritual, dan keterampilan.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($programs as $program)
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">
                <div class="w-16 h-16 green-gradient rounded-2xl flex items-center justify-center text-white mb-6 group-hover:bg-yellow-400 group-hover:text-emerald-900 transition-colors duration-300">
                    @if(Str::startsWith($program->icon, '<svg')){!! $program->icon !!}@else<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>@endif
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $program->title }}</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">{{ Str::limit($program->description, 120) }}</p>
                <a href="#" class="text-emerald-700 font-semibold text-sm hover:underline">Pelajari Detail &rarr;</a>
            </div>
            @empty
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-lg hover:shadow-xl transition-all hover:-translate-y-2 group">
                <div class="w-16 h-16 green-gradient rounded-2xl flex items-center justify-center text-white mb-6"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Tahfidzul Qur'an</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">Program unggulan menghafal Al-Qur'an 30 Juz dengan sanad bersambung.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-lg hover:shadow-xl transition-all hover:-translate-y-2 group">
                <div class="w-16 h-16 green-gradient rounded-2xl flex items-center justify-center text-white mb-6"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg></div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Pendidikan Umum & Agama</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">Kurikulum terpadu yang memadukan ilmu umum dan pendidikan agama Islam.</p>
            </div>
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-lg hover:shadow-xl transition-all hover:-translate-y-2 group">
                <div class="w-16 h-16 green-gradient rounded-2xl flex items-center justify-center text-white mb-6"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Pembinaan Karakter</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">Membentuk karakter santri yang mandiri, disiplin dan berakhlakul karimah.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@include('landing.partials.bottom')

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Hero Swiper
    new Swiper('.heroSwiper', {
        loop: true, autoplay: { delay: 5000, disableOnInteraction: false },
        effect: 'fade', fadeEffect: { crossFade: true },
        pagination: { el: '.swiper-pagination', clickable: true },
    });
    // Mobile Menu
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    });
    // Close mobile menu on link click
    document.querySelectorAll('#mobileMenu a').forEach(link => {
        link.addEventListener('click', () => document.getElementById('mobileMenu').classList.add('hidden'));
    });
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('mainNav');
        if (window.scrollY > 50) { nav.classList.add('nav-scrolled', 'bg-white'); nav.classList.remove('bg-white/95'); }
        else { nav.classList.remove('nav-scrolled'); nav.classList.add('bg-white/95'); }
    });
</script>
@livewireScripts
</body>
</html>
