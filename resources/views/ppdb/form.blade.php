<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - PPDB PONSPES</title>
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
                <a href="{{ route('ppdb') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="text-center mb-8">
            <h1 class="font-heading text-3xl font-bold text-gray-900 mb-2">Formulir Pendaftaran Santri Baru</h1>
            <p class="text-gray-600">Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
        </div>

        <livewire:ppdb.ppdb-form />
    </div>

    <!-- Footer -->
    <footer class="py-8 text-center text-gray-500 text-sm">
        <p>&copy; {{ date('Y') }} Pondok Pesantren. All rights reserved.</p>
    </footer>
</body>
</html>
