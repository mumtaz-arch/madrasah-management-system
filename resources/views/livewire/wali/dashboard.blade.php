<div>
    @if($wali)
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div>
                <p class="text-primary-100 text-sm">Assalamu'alaikum,</p>
                <h1 class="font-heading text-2xl font-bold">{{ $wali->nama_lengkap }}</h1>
                <p class="text-primary-200 text-sm mt-1">Portal Wali Santri | {{ $santris->count() }} Anak Terdaftar</p>
            </div>
        </div>

        @forelse($santris as $santri)
            <!-- Anak Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold">
                            {{ strtoupper(substr($santri->nama_lengkap, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="font-heading font-semibold text-gray-900">{{ $santri->nama_lengkap }}</h3>
                            <p class="text-sm text-gray-500">NIS: {{ $santri->nis }} | {{ $santri->kelas->nama_kelas ?? 'Belum ada kelas' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-primary-600">{{ round($santri->rata_rata, 1) }}</p>
                        <p class="text-xs text-gray-500">Rata-rata Nilai</p>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jadwal Hari Ini -->
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Jadwal Hari Ini
                            </h4>
                            @if($santri->jadwal_hari_ini->count() > 0)
                                <div class="space-y-2">
                                    @foreach($santri->jadwal_hari_ini as $jadwal)
                                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <span class="text-sm font-mono text-primary-600">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
                                                <span class="text-sm text-gray-700">{{ $jadwal->mapel->nama }}</span>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $jadwal->guru->nama_lengkap }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">Tidak ada jadwal hari ini</p>
                            @endif
                        </div>

                        <!-- Nilai Terbaru -->
                        <div>
                            <h4 class="font-medium text-gray-900 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Nilai Terbaru
                            </h4>
                            @if($santri->nilai_terbaru->count() > 0)
                                <div class="space-y-2">
                                    @foreach($santri->nilai_terbaru as $nilai)
                                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                                            <div>
                                                <span class="text-sm text-gray-700">{{ $nilai->mapel->nama }}</span>
                                                <span class="text-xs text-gray-500 ml-2">({{ $nilai->jenis }})</span>
                                            </div>
                                            <span class="font-bold {{ $nilai->nilai >= $nilai->mapel->kkm ? 'text-green-600' : 'text-red-600' }}">
                                                {{ number_format($nilai->nilai, 0) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">Belum ada nilai</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
                <svg class="w-12 h-12 mx-auto text-yellow-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <h3 class="font-semibold text-yellow-800 mb-2">Belum Ada Anak Terdaftar</h3>
                <p class="text-yellow-600">Silakan hubungi admin untuk menghubungkan data santri dengan akun Anda.</p>
            </div>
        @endforelse
    @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
            <svg class="w-12 h-12 mx-auto text-yellow-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <h3 class="font-semibold text-yellow-800 mb-2">Data Wali Tidak Ditemukan</h3>
            <p class="text-yellow-600">Akun Anda belum terhubung dengan data wali. Silakan hubungi admin.</p>
        </div>
    @endif
</div>
