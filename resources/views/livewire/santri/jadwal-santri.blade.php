<div>
    <h1 class="font-heading text-2xl font-bold text-gray-900 mb-2">Jadwal Pelajaran</h1>
    <p class="text-gray-500 mb-6">{{ $santri->kelas->nama_kelas ?? 'Kelas tidak ditemukan' }}</p>

    @if($jadwals->count() > 0)
        <div class="space-y-6">
            @foreach(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu'] as $hari)
                @if(isset($jadwals[$hari]))
                    @php
                        $dayColors = [
                            'senin' => 'bg-blue-500',
                            'selasa' => 'bg-green-500',
                            'rabu' => 'bg-yellow-500',
                            'kamis' => 'bg-purple-500',
                            'jumat' => 'bg-red-500',
                            'sabtu' => 'bg-pink-500',
                        ];
                    @endphp
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-3 {{ $dayColors[$hari] }} text-white font-semibold">
                            {{ ucfirst($hari) }}
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($jadwals[$hari] as $jadwal)
                                <div class="px-6 py-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-center min-w-[60px]">
                                            <p class="font-bold text-primary-600">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $jadwal->mapel->nama }}</p>
                                            <p class="text-sm text-gray-500">{{ $jadwal->guru->nama_lengkap }}</p>
                                        </div>
                                    </div>
                                    <span class="inline-flex px-2 py-1 text-xs font-mono rounded bg-gray-100 text-gray-600">
                                        {{ $jadwal->mapel->kode }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-500">Jadwal belum tersedia</p>
        </div>
    @endif
</div>
