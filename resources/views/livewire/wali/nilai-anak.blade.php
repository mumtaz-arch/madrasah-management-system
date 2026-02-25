<div>
    <!-- Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Nilai Anak</h1>
            <p class="text-gray-500">Pantau perkembangan nilai akademik anak Anda</p>
        </div>
        @if($selectedSantri)
        <a href="{{ route('wali.rapor.download', $selectedSantri->id) }}" target="_blank"
           class="inline-flex items-center px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Download Rapor
        </a>
        @endif
    </div>

    <!-- Santri Selector -->
    @if($santris->count() > 1)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Anak</label>
        <div class="flex flex-wrap gap-2">
            @foreach($santris as $santri)
                <button wire:click="$set('selectedSantriId', {{ $santri->id }})"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                    {{ $selectedSantriId == $santri->id ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $santri->nama_lengkap }}
                </button>
            @endforeach
        </div>
    </div>
    @endif

    @if($selectedSantri)
    <!-- Info Anak -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-xl">
                {{ strtoupper(substr($selectedSantri->nama_lengkap, 0, 1)) }}
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">{{ $selectedSantri->nama_lengkap }}</h3>
                <p class="text-sm text-gray-500">{{ $selectedSantri->kelas->nama_kelas ?? '-' }} • NIS: {{ $selectedSantri->nis }}</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
            <select wire:model.live="semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="ganjil">Ganjil</option>
                <option value="genap">Genap</option>
            </select>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
            <input type="text" wire:model.live="tahunAjaran" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-sm text-gray-500">Rata-rata</p>
            <p class="text-2xl font-bold text-primary-600">{{ $stats['rata_rata'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-sm text-gray-500">Tertinggi</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['tertinggi'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-sm text-gray-500">Terendah</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['terendah'] }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
            <p class="text-sm text-gray-500">Total Mapel</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['total_mapel'] }}</p>
        </div>
    </div>

    <!-- Grafik Nilai -->
    @if(count($nilaiData) > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="font-semibold text-gray-900 mb-4">📊 Grafik Nilai per Mata Pelajaran</h3>
        <div class="h-64">
            <canvas id="nilaiChart"></canvas>
        </div>
    </div>
    @endif

    <!-- Nilai Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="font-semibold text-gray-900">Daftar Nilai</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Tugas</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">UTS</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">UAS</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Rata-rata</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($nilaiData as $nilai)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $nilai['mapel'] }}</td>
                        <td class="px-6 py-4 text-center">{{ $nilai['tugas'] ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">{{ $nilai['uts'] ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">{{ $nilai['uas'] ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($nilai['rata_rata'])
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    {{ $nilai['rata_rata'] >= 75 ? 'bg-green-100 text-green-700' : ($nilai['rata_rata'] >= 60 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $nilai['rata_rata'] }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Belum ada data nilai untuk periode ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak Ada Data Anak</h3>
        <p class="text-gray-500">Anda belum memiliki data anak yang terdaftar.</p>
    </div>
    @endif
</div>

@if($selectedSantri && count($nilaiData) > 0)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('nilaiChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: @json($chartValues),
                    backgroundColor: @json($chartColors),
                    borderColor: @json($chartBorders),
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endif
