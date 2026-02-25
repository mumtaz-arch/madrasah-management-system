<x-layouts.admin>
    <x-slot:title>Ringkasan Akademik</x-slot:title>
    <x-slot:header>Ringkasan Akademik</x-slot:header>
    
    <div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="font-heading text-2xl font-bold text-gray-900">Ringkasan Akademik</h1>
                <p class="text-gray-500">Statistik nilai per kelas</p>
            </div>
            <a href="{{ route('admin.rapor.index') }}" class="btn-secondary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($summary as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-lg text-gray-900">{{ $item['kelas'] }}</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            {{ $item['rata_rata'] >= 80 ? 'bg-green-100 text-green-700' : '' }}
                            {{ $item['rata_rata'] >= 70 && $item['rata_rata'] < 80 ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $item['rata_rata'] < 70 ? 'bg-red-100 text-red-700' : '' }}">
                            {{ $item['rata_rata'] }}
                        </span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Jumlah Santri</span>
                            <span class="font-medium">{{ $item['jumlah_santri'] }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Rata-rata Nilai</span>
                            <span class="font-medium">{{ $item['rata_rata'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="h-2 rounded-full {{ $item['rata_rata'] >= 80 ? 'bg-green-500' : ($item['rata_rata'] >= 70 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                 style="width: {{ min($item['rata_rata'], 100) }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(count($summary) == 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h3 class="font-semibold text-gray-700">Belum ada data</h3>
            </div>
        @endif
    </div>
</x-layouts.admin>
