<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Online - PONSPES</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-primary-50 to-secondary-50 min-h-screen">
    <!-- Header -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('img/logo-ponpes.png') }}" alt="Logo Pondok Pesantren" class="w-10 h-10 rounded-full object-contain bg-primary-600 p-1">
                    <span class="font-heading font-bold text-xl text-gray-900">PONSPES</span>
                </a>
                <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-medium">Login</a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center px-4 py-2 bg-secondary-100 text-secondary-700 rounded-full text-sm font-medium mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Pendaftaran Dibuka!
            </div>
            <h1 class="font-heading text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                PPDB Online<br>
                <span class="text-primary-600">Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Daftarkan putra-putri Anda untuk menjadi bagian dari keluarga besar Pondok Pesantren kami
            </p>
        </div>

        <!-- Features -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 mx-auto bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 mb-2">Pendidikan Berkualitas</h3>
                <p class="text-sm text-gray-500">Kurikulum terpadu dengan standar nasional</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 mx-auto bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 mb-2">Program Tahfidz</h3>
                <p class="text-sm text-gray-500">Bimbingan hafalan Al-Quran intensif</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 mx-auto bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="font-heading font-semibold text-gray-900 mb-2">Pengasuhan 24 Jam</h3>
                <p class="text-sm text-gray-500">Lingkungan asrama yang kondusif</p>
            </div>
        </div>

        <!-- CTA -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 text-center">
            <h2 class="font-heading text-2xl font-bold text-gray-900 mb-4">Siap Bergabung?</h2>
            <p class="text-gray-600 mb-6">Isi formulir pendaftaran online sekarang dan jadilah bagian dari keluarga besar kami.</p>
            <a href="{{ route('ppdb.form') }}" class="inline-flex items-center px-8 py-4 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-600/30">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Daftar Sekarang
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-8 text-center text-gray-500 text-sm">
        <p>&copy; {{ date('Y') }} Pondok Pesantren. All rights reserved.</p>
    </footer>
</body>
</html>
