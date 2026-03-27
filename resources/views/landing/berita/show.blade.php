<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->title }} - Ponpes Pancasila Reo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        secondary: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Quill JS Typography Styles for Frontend */
        .prose h1 { font-size: 2.25rem; font-weight: 800; margin-top: 2rem; margin-bottom: 1rem; color: #111827; }
        .prose h2 { font-size: 1.875rem; font-weight: 700; margin-top: 1.75rem; margin-bottom: 0.75rem; color: #111827; }
        .prose h3 { font-size: 1.5rem; font-weight: 600; margin-top: 1.5rem; margin-bottom: 0.75rem; color: #1f2937; }
        .prose p { margin-bottom: 1.25rem; line-height: 1.8; color: #374151; }
        .prose a { color: #16a34a; text-decoration: underline; }
        .prose blockquote { border-left: 4px solid #16a34a; padding-left: 1rem; color: #4b5563; font-style: italic; margin-top: 1.5rem; margin-bottom: 1.5rem; }
        .prose ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; color: #374151; }
        .prose ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1.25rem; color: #374151; }
        .prose img { max-width: 100%; border-radius: 0.5rem; margin-top: 2rem; margin-bottom: 2rem; }
        .prose pre { background-color: #1f2937; color: #f9fafb; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; margin-bottom: 1.5rem; }
    </style>
</head>
<body class="bg-gray-50 antialiased pt-20 text-gray-800 flex flex-col min-h-screen">

    <!-- Header / Navbar Minimalist (Same as Landing) -->
    <header class="fixed top-0 inset-x-0 bg-white/95 backdrop-blur-md shadow-sm z-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex items-center justify-between h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=PR&color=ffffff&background=16a34a&rounded=true" alt="Logo" class="w-10 h-10 shadow-sm">
                    <div class="flex flex-col">
                        <span class="font-bold text-lg text-gray-900 leading-tight">Ponpes Pancasila</span>
                        <span class="text-xs text-primary-600 font-semibold tracking-wide uppercase">Reo Manggarai</span>
                    </div>
                </a>
                
                <nav class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-600 font-medium transition-colors">Beranda</a>
                    <a href="{{ route('home') }}#tentang" class="text-gray-600 hover:text-primary-600 font-medium transition-colors">Tentang Kami</a>
                    <a href="{{ route('home') }}#berita" class="text-primary-600 font-bold transition-colors">Berita</a>
                </nav>

                <div class="flex items-center gap-4">
                    <a href="{{ route('ppdb') }}" class="hidden md:inline-flex items-center justify-center px-6 py-2.5 rounded-full bg-secondary-500 hover:bg-secondary-600 text-white font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Daftar PPDB
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-12 md:py-20 flex-grow">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col lg:flex-row gap-12">
                
                <!-- Article Content -->
                <article class="w-full lg:w-2/3 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    @if($berita->image)
                        <div class="w-full aspect-[21/9] relative bg-gray-100">
                            <img src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->title }}" class="absolute inset-0 w-full h-full object-cover">
                        </div>
                    @endif
                    
                    <div class="p-8 md:p-12">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary-50 text-primary-700 text-xs font-bold tracking-wide uppercase">
                                Pengumuman
                            </span>
                            <span class="text-gray-500 text-sm font-medium flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($berita->published_at ?? $berita->created_at)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 mb-8 leading-tight">
                            {{ $berita->title }}
                        </h1>
                        
                        <div class="prose max-w-none text-lg">
                            {!! $berita->content !!}
                        </div>
                        
                        <div class="mt-12 pt-8 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('home') }}#berita" class="inline-flex items-center text-primary-600 font-semibold hover:text-primary-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Kembali ke Berita
                            </a>
                            
                            <!-- Simple Share Buttons -->
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-500">Bagikan:</span>
                                <button class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </button>
                                <button class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Sidebar / Berita Lainnya -->
                <aside class="w-full lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 sticky top-28">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <span class="w-2 h-6 rounded-full bg-primary-500"></span>
                            Berita Terbaru
                        </h3>
                        
                        <div class="space-y-6">
                            @forelse($relatedNews as $related)
                                <a href="{{ route('berita.show', $related->slug) }}" class="group block">
                                    <div class="flex gap-4 items-start">
                                        @if($related->image)
                                            <div class="w-24 h-20 rounded-lg overflow-hidden shrink-0 bg-gray-100">
                                                <img src="{{ asset('storage/' . $related->image) }}" alt="Thumbnail" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            </div>
                                        @else
                                            <div class="w-24 h-20 rounded-lg overflow-hidden shrink-0 bg-primary-50 flex items-center justify-center text-primary-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-sm leading-snug group-hover:text-primary-600 transition-colors line-clamp-2 mb-1">
                                                {{ $related->title }}
                                            </h4>
                                            <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($related->published_at ?? $related->created_at)->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <p class="text-sm text-gray-500">Belum ada berita lainnya.</p>
                            @endforelse
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </main>

    <!-- Simple Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4 md:px-6 text-center">
            <!-- Footer from existing or simple text for detail page -->
            <p class="text-gray-400">&copy; {{ date('Y') }} Pondok Pesantren Pancasila Reo Manggarai. Semua hak dilindungi.</p>
        </div>
    </footer>

</body>
</html>
