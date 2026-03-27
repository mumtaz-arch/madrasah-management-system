<!-- Prestasi Section -->
@if(count($achievements) > 0)
<section id="prestasi" class="py-24 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-emerald-700 font-bold tracking-[0.15em] uppercase text-xs mb-2 block">Pencapaian</span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6">Prestasi Kami</h2>
            <p class="text-gray-500 text-lg">Berbagai pencapaian yang diraih santri dan pesantren dalam berbagai bidang.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($achievements as $achievement)
            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-600 mb-6">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                <p class="text-yellow-600 font-bold text-sm mb-2">{{ $achievement['year'] ?? '' }}</p>
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

<!-- Testimoni Section -->
@if(count($testimonials) > 0)
<section id="testimoni" class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-emerald-700 font-bold tracking-[0.15em] uppercase text-xs mb-2 block">Testimoni</span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6">Kata Mereka</h2>
            <p class="text-gray-500 text-lg">Pengalaman dan kesan dari wali santri, alumni, dan masyarakat.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
            <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 relative hover:shadow-lg transition-all">
                <svg class="w-10 h-10 text-emerald-200 absolute top-6 right-6" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                <p class="text-gray-600 leading-relaxed mb-6 italic">"{{ $testimonial['text'] }}"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full green-gradient flex items-center justify-center text-white font-bold text-lg">{{ strtoupper(substr($testimonial['name'], 0, 1)) }}</div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $testimonial['name'] }}</p>
                        <p class="text-emerald-700 text-sm">{{ $testimonial['role'] ?? '' }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Guru / Asatidz Section -->
<section id="guru" class="py-24 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
            <div class="max-w-2xl">
                <span class="text-emerald-700 font-bold tracking-[0.15em] uppercase text-xs mb-2 block">Asatidz & Ustadzah</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Tim Pengajar Terbaik</h2>
                <p class="text-gray-500 mt-4 text-lg">Dibimbing oleh tenaga pengajar alumni pesantren ternama dan lulusan perguruan tinggi terbaik.</p>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            @forelse($gurus as $guru)
            <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="aspect-[3/4] overflow-hidden bg-gray-200 relative">
                    @if($guru->foto)
                    <img loading="lazy" src="{{ asset('storage/'.$guru->foto) }}" alt="{{ $guru->nama_lengkap }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-emerald-50 text-emerald-300"><svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div>
                    @endif
                </div>
                <div class="p-6 text-center">
                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">{{ $guru->nama_lengkap }}</h4>
                    <p class="text-emerald-600 text-sm font-medium mt-1 uppercase tracking-wide">{{ $guru->jabatan ?? 'Pengajar' }}</p>
                </div>
            </div>
            @empty
            @foreach(range(1, 4) as $i)
            <div class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100">
                <div class="aspect-[3/4] overflow-hidden bg-emerald-50 relative flex items-center justify-center"><svg class="w-16 h-16 text-emerald-200" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div>
                <div class="p-6 text-center">
                    <h4 class="text-lg font-bold text-gray-900">Ustadz/Ustadzah</h4>
                    <p class="text-emerald-600 text-sm font-medium mt-1 uppercase tracking-wide">Pengajar</p>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

<!-- Berita Section -->
<section id="berita" class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-emerald-700 font-bold tracking-[0.15em] uppercase text-xs mb-2 block">Informasi & Pengumuman</span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-6">Berita Terkini</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @forelse($announcements as $news)
            <a href="{{ route('berita.show', $news->slug) }}" class="flex flex-col group cursor-pointer h-full">
                <div class="rounded-2xl overflow-hidden h-64 mb-6 relative shadow-sm border border-gray-100 shrink-0">
                    @if($news->image)
                        <img loading="lazy" src="{{ asset('storage/' . $news->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $news->title }}">
                    @else
                        <div class="w-full h-full bg-emerald-50 flex items-center justify-center text-emerald-300 group-hover:scale-105 transition-transform duration-500">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-4 left-4 bg-emerald-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold shadow">{{ \Carbon\Carbon::parse($news->published_at ?? $news->created_at)->translatedFormat('d M Y') }}</div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-emerald-700 transition-colors leading-snug">{{ $news->title }}</h3>
                <p class="text-gray-500 leading-relaxed mb-4 line-clamp-3">{{ $news->excerpt ?? Str::limit(strip_tags($news->content), 120) }}</p>
                <span class="text-emerald-700 font-semibold text-sm group-hover:underline mt-auto">Baca Selengkapnya &rarr;</span>
            </a>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Belum ada berita atau informasi terbaru saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- CTA Registration Section -->
<section class="green-gradient py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5" style="background-image: url('https://www.transparenttextures.com/patterns/arabesque.png');"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="relative hidden lg:block">
                <div class="grid grid-cols-2 gap-4">
                    <img src="{{ $aboutUrl }}" alt="Campus" class="rounded-2xl shadow-2xl w-full h-44 object-cover border-4 border-white/20">
                    <img src="{{ $heroBg }}" alt="Campus" class="rounded-2xl shadow-2xl w-full h-44 object-cover border-4 border-white/20 translate-y-8">
                </div>
                <div class="absolute -bottom-4 left-4 w-6 h-6 bg-yellow-400 rounded-full"></div>
                <div class="absolute top-2 -right-2 w-4 h-4 bg-emerald-300 rounded-full"></div>
            </div>
            <div class="text-center lg:text-left">
                <p class="text-yellow-400 font-bold uppercase tracking-[0.2em] text-sm mb-4">Bergabung Bersama Kami</p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Ikuti Penerimaan Santri Baru Ponpes Pancasila Reo</h2>
                <div class="w-16 h-1 bg-yellow-400 mb-6 mx-auto lg:mx-0"></div>
                <p class="text-yellow-300 font-bold text-lg mb-8">Mari bergabung menjadi bagian Pondok Pesantren terbaik di Manggarai!</p>
                <a href="/ppdb" class="inline-block px-10 py-5 text-lg font-bold text-emerald-900 bg-white rounded-2xl hover:bg-yellow-400 shadow-2xl transition-all hover:-translate-y-1">DAFTAR SANTRI BARU 2026/2027</a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer id="kontak" class="green-gradient text-white pt-20 pb-10">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-16">
            <!-- Branding -->
            <div>
                <a href="#" class="flex items-center gap-3 mb-6">
                    <img loading="lazy" src="{{ asset('img/logo-ponpes.png') }}" alt="Logo" class="h-12 w-auto bg-white rounded-full p-1">
                    <div class="leading-tight">
                        <span class="block font-extrabold text-lg text-white">PONPES PANCASILA</span>
                        <span class="block text-xs font-semibold text-emerald-200 tracking-[0.15em]">REO - MANGGARAI</span>
                    </div>
                </a>
                <div class="w-12 h-1 bg-yellow-400 mb-4"></div>
                <p class="text-emerald-100 leading-relaxed text-sm mb-6">{{ $footerText }}</p>
                <div class="flex gap-4">
                    <a href="{{ \App\Models\LandingPageContent::where('key', 'social_facebook')->value('value') ?? '#' }}" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-yellow-400 hover:text-emerald-900 text-white transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    <a href="{{ \App\Models\LandingPageContent::where('key', 'social_instagram')->value('value') ?? '#' }}" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-yellow-400 hover:text-emerald-900 text-white transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    <a href="{{ \App\Models\LandingPageContent::where('key', 'social_youtube')->value('value') ?? '#' }}" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-yellow-400 hover:text-emerald-900 text-white transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                    <a href="https://wa.me/{{ \App\Models\LandingPageContent::where('key', 'social_whatsapp')->value('value') ?? '' }}" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-yellow-400 hover:text-emerald-900 text-white transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
                </div>
            </div>

            <!-- Links -->
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <h4 class="text-white font-bold uppercase tracking-[0.15em] text-xs mb-6">Tentang Kami</h4>
                    <ul class="space-y-3 text-emerald-100 text-sm">
                        <li><a href="#tentang" class="hover:text-yellow-400 transition-colors">Profil Pondok</a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Sejarah</a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Visi & Misi</a></li>
                        <li><a href="#guru" class="hover:text-yellow-400 transition-colors">Struktur Organisasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold uppercase tracking-[0.15em] text-xs mb-6">Pendidikan</h4>
                    <ul class="space-y-3 text-emerald-100 text-sm">
                        <li><a href="#program" class="hover:text-yellow-400 transition-colors">KMI / Madrasah</a></li>
                        <li><a href="#program" class="hover:text-yellow-400 transition-colors">Tahfidzul Qur'an</a></li>
                        <li><a href="#" class="hover:text-yellow-400 transition-colors">Ekstrakurikuler</a></li>
                        <li><a href="/ppdb" class="hover:text-yellow-400 transition-colors">Pendaftaran</a></li>
                    </ul>
                </div>
            </div>

            <!-- Contact + Map -->
            <div>
                <h4 class="text-white font-bold uppercase tracking-[0.15em] text-xs mb-6">Hubungi Kami</h4>
                <ul class="space-y-4 text-emerald-100 text-sm mb-6">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>{{ \App\Models\LandingPageContent::where('key', 'contact_address')->value('value') ?? 'Jl. Pesantren No. 1, Reo, Manggarai, NTT' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-yellow-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>{{ \App\Models\LandingPageContent::where('key', 'contact_phone')->value('value') ?? '(0385) 123456' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-yellow-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>{{ \App\Models\LandingPageContent::where('key', 'contact_email')->value('value') ?? 'info@ponpespancasila.sch.id' }}</span>
                    </li>
                </ul>
                @if($mapEmbed)
                <div class="rounded-xl overflow-hidden border-2 border-white/20 h-40">
                    <iframe src="{{ $mapEmbed }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                @endif
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-white/20 pt-8 text-center">
            <p class="text-emerald-200 text-sm">&copy; {{ date('Y') }} Pondok Pesantren Pancasila Reo. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- WhatsApp Floating Button -->
@php $waNumber = \App\Models\LandingPageContent::where('key', 'social_whatsapp')->value('value') ?? ''; @endphp
@if($waNumber)
<a href="https://wa.me/{{ $waNumber }}" target="_blank" class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 rounded-full flex items-center justify-center shadow-xl hover:bg-green-600 hover:scale-110 transition-all">
    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>
@endif
