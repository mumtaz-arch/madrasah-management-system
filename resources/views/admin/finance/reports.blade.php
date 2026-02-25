<x-layouts.admin>
    <x-slot:title>Laporan Keuangan</x-slot:title>
    <x-slot:header>Laporan Keuangan</x-slot:header>
    
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="font-heading text-2xl font-bold text-gray-900">Generate Laporan Keuangan</h1>
            <p class="text-gray-500">Pilih jenis laporan dan periode yang diinginkan</p>
        </div>

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Monthly Report --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Laporan Bulanan</h3>
                <p class="text-sm text-gray-500 mb-4">Detail pembayaran per bulan</p>
                <form action="{{ route('admin.finance.reports.generate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="monthly">
                    <input type="month" name="month" value="{{ now()->format('Y-m') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3 focus:ring-2 focus:ring-primary-500">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                        Download PDF
                    </button>
                </form>
            </div>

            {{-- Yearly Report --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Laporan Tahunan</h3>
                <p class="text-sm text-gray-500 mb-4">Ringkasan pembayaran per tahun</p>
                <form action="{{ route('admin.finance.reports.generate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="yearly">
                    <select name="year" class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3 focus:ring-2 focus:ring-primary-500">
                        @for($y = now()->year; $y >= 2020; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors">
                        Download PDF
                    </button>
                </form>
            </div>

            {{-- Summary Report --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Ringkasan</h3>
                <p class="text-sm text-gray-500 mb-4">Ringkasan keseluruhan keuangan</p>
                <form action="{{ route('admin.finance.reports.generate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="summary">
                    <div class="h-[42px] mb-3"></div>
                    <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium transition-colors">
                        Download PDF
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
