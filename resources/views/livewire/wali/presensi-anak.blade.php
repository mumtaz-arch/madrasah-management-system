<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="font-heading text-2xl font-bold text-gray-900">Presensi Anak</h1>
        <p class="text-gray-500">Pantau kehadiran anak Anda di sekolah</p>
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
    <!-- Info & Filter -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                    {{ strtoupper(substr($selectedSantri->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 text-sm">{{ $selectedSantri->nama_lengkap }}</h3>
                    <p class="text-xs text-gray-500">{{ $selectedSantri->kelas->nama_kelas ?? '-' }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <label class="block text-xs font-medium text-gray-500 mb-1">Bulan</label>
            <select wire:model.live="bulan" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                @foreach($bulanList as $key => $nama)
                    <option value="{{ $key }}">{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <label class="block text-xs font-medium text-gray-500 mb-1">Tahun</label>
            <select wire:model.live="tahun" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                @for($y = date('Y'); $y >= date('Y') - 2; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
            <p class="text-xs text-green-600 font-medium">Hadir</p>
            <p class="text-2xl font-bold text-green-700">{{ $stats['hadir'] }}</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
            <p class="text-xs text-blue-600 font-medium">Izin</p>
            <p class="text-2xl font-bold text-blue-700">{{ $stats['izin'] }}</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">
            <p class="text-xs text-yellow-600 font-medium">Sakit</p>
            <p class="text-2xl font-bold text-yellow-700">{{ $stats['sakit'] }}</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
            <p class="text-xs text-red-600 font-medium">Alpha</p>
            <p class="text-2xl font-bold text-red-700">{{ $stats['alpha'] }}</p>
        </div>
        <div class="bg-primary-50 border border-primary-200 rounded-xl p-4 text-center">
            <p class="text-xs text-primary-600 font-medium">Kehadiran</p>
            <p class="text-2xl font-bold text-primary-700">{{ $stats['persentase'] }}%</p>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="font-semibold text-gray-900">Kalender Kehadiran</h3>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-7 gap-2">
                @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $day)
                    <div class="text-center text-xs font-semibold text-gray-500 py-2">{{ $day }}</div>
                @endforeach
                <div></div>
            </div>
            <div class="grid grid-cols-7 gap-2 mt-2">
                @php $currentWeekDay = 0; @endphp
                @foreach($presensiData as $index => $data)
                    @php
                        $dayIndex = match($data['hari']) {
                            'Senin' => 0, 'Selasa' => 1, 'Rabu' => 2, 
                            'Kamis' => 3, 'Jumat' => 4, 'Sabtu' => 5,
                            default => 0
                        };
                        // Fill empty cells at start of week
                        if ($index === 0) {
                            for ($i = 0; $i < $dayIndex; $i++) {
                                echo '<div></div>';
                            }
                        }
                    @endphp
                    <div class="aspect-square flex items-center justify-center rounded-lg text-sm font-medium
                        @if($data['status'] === 'hadir') bg-green-100 text-green-700
                        @elseif($data['status'] === 'izin') bg-blue-100 text-blue-700
                        @elseif($data['status'] === 'sakit') bg-yellow-100 text-yellow-700
                        @elseif($data['status'] === 'alpha') bg-red-100 text-red-700
                        @else bg-gray-50 text-gray-400
                        @endif"
                        title="{{ $data['hari'] }}, {{ $data['tanggal'] }}: {{ ucfirst($data['status'] ?? 'Belum ada data') }}">
                        {{ $data['tanggal_display'] }}
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Legend -->
        <div class="px-6 py-4 border-t border-gray-200 flex flex-wrap gap-4">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-green-100"></div>
                <span class="text-xs text-gray-600">Hadir</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-blue-100"></div>
                <span class="text-xs text-gray-600">Izin</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-yellow-100"></div>
                <span class="text-xs text-gray-600">Sakit</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 rounded bg-red-100"></div>
                <span class="text-xs text-gray-600">Alpha</span>
            </div>
        </div>
    </div>

    <!-- Detailed Log Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mt-6 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="font-semibold text-gray-900">Rincian Waktu Kehadiran</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Waktu Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Waktu Pulang</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach(array_reverse(array_filter($presensiData, fn($d) => $d['status'] !== null)) as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $log['hari'] }}, {{ \Carbon\Carbon::parse($log['tanggal'])->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full 
                                    {{ $log['status'] === 'hadir' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $log['status'] === 'izin' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $log['status'] === 'sakit' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $log['status'] === 'alpha' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ ucfirst($log['status']) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $log['waktu_masuk'] ? substr($log['waktu_masuk'], 0, 5) : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $log['waktu_pulang'] ? substr($log['waktu_pulang'], 0, 5) : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $log['keterangan'] ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                    @if(empty(array_filter($presensiData, fn($d) => $d['status'] !== null)))
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada catatan kehadiran bulan ini.</td>
                        </tr>
                    @endif
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
