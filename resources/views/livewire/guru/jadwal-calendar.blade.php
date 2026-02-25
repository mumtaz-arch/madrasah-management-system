<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="font-heading text-2xl font-bold text-gray-900">Jadwal Mengajar Saya</h1>
        <p class="text-gray-500">Lihat jadwal mengajar Anda dalam minggu ini</p>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @php
            $totalJadwal = $jadwals->count();
            $totalKelas = $jadwals->pluck('kelas_id')->unique()->count();
            $totalMapel = $jadwals->pluck('mapel_id')->unique()->count();
            $jamMengajar = $jadwals->sum(function($j) {
                return \Carbon\Carbon::parse($j->jam_selesai)->diffInMinutes(\Carbon\Carbon::parse($j->jam_mulai)) / 60;
            });
        @endphp
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Total Jadwal</p>
            <p class="text-2xl font-bold text-primary-600">{{ $totalJadwal }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Kelas Diampu</p>
            <p class="text-2xl font-bold text-blue-600">{{ $totalKelas }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Mata Pelajaran</p>
            <p class="text-2xl font-bold text-purple-600">{{ $totalMapel }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <p class="text-sm text-gray-500">Jam/Minggu</p>
            <p class="text-2xl font-bold text-orange-600">{{ number_format($jamMengajar, 1) }}</p>
        </div>
    </div>

    <!-- Daily Grid -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">
                Jadwal Hari Ini: <span class="text-primary-600">{{ ucfirst($hariIni) }}</span>
            </h2>
            <div class="text-sm text-gray-500">
                {{ now()->locale('id')->isoFormat('D MMMM Y') }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jadwals as $jadwal)
                <button 
                    wire:click="openJournalModal({{ $jadwal->id }})"
                    class="relative group bg-white border rounded-xl p-5 text-left transition-all hover:shadow-md hover:border-primary-300 focus:outline-none {{ $jadwal->is_filled ? 'border-green-200 bg-green-50/30' : 'border-gray-200' }}">
                    
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-sm font-medium bg-primary-50 text-primary-700">
                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                        </span>
                        @if($jadwal->is_filled)
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                        @endif
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-primary-600 transition-colors">
                        {{ $jadwal->mapel->nama }}
                    </h3>
                    
                    <div class="flex items-center text-gray-500 text-sm mb-4">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        {{ $jadwal->kelas->nama_kelas }}
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-sm">
                        <span class="text-gray-500">Ruang: {{ $jadwal->ruangan ?? '-' }}</span>
                        @if(!$jadwal->is_filled)
                            <span class="text-primary-600 font-medium group-hover:underline">Isi Jurnal &rarr;</span>
                        @else
                            <span class="text-green-600 font-medium">Selesai</span>
                        @endif
                    </div>
                </button>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3">
                    <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada jadwal hari ini</h3>
                        <p class="mt-1 text-sm text-gray-500">Selamat beristirahat atau persiapkan materi untuk besok.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Journal Modal -->
    @if($showJournalModal && $selectedJadwal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeJournalModal"></div>
                
                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form wire:submit.prevent="saveJournal">
                        <!-- Modal Header -->
                        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-5 py-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-base font-bold text-white">Input Jurnal Mengajar</h3>
                                    <p class="text-primary-100 text-xs mt-0.5">{{ $selectedJadwal->mapel->nama }} — {{ $selectedJadwal->kelas->nama_kelas }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-white/90 text-xs bg-white/20 px-2.5 py-1 rounded-full font-medium">{{ \Carbon\Carbon::parse($selectedJadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($selectedJadwal->jam_selesai)->format('H:i') }}</span>
                                    <button type="button" wire:click="closeJournalModal" class="text-white/70 hover:text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Body -->
                        <div class="px-5 py-4 space-y-4 max-h-[75vh] overflow-y-auto">
                            <!-- Outside Time Warning -->
                            @if($isOutsideTime)
                                <div class="rounded-lg bg-amber-50 border border-amber-200 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-semibold text-amber-800">Diluar Jam Pengisian</h3>
                                            <p class="text-sm text-amber-700 mt-1">{{ $outsideTimeMessage }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Materi & Metode -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Materi Pembelajaran <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="journalForm.topic" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 text-sm py-2 {{ $isOutsideTime ? 'bg-gray-100 cursor-not-allowed' : '' }}" placeholder="Contoh: Bab 1 - Aljabar" {{ $isOutsideTime ? 'disabled' : '' }}>
                                    @error('journalForm.topic') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Metode Pembelajaran <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="journalForm.method" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 text-sm py-2 {{ $isOutsideTime ? 'bg-gray-100 cursor-not-allowed' : '' }}" placeholder="Contoh: Ceramah dan Diskusi" {{ $isOutsideTime ? 'disabled' : '' }}>
                                    @error('journalForm.method') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Attendance Section -->
                            <div x-data="{ search: '' }">
                                @php
                                    $hadirCount = collect($attendanceList)->where('status', 'H')->count();
                                    $sakitCount = collect($attendanceList)->where('status', 'S')->count();
                                    $izinCount = collect($attendanceList)->where('status', 'I')->count();
                                    $alfaCount = collect($attendanceList)->where('status', 'A')->count();
                                @endphp
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-xs font-semibold text-gray-600">Kehadiran Santri ({{ count($attendanceList) }})</label>
                                    <div class="flex items-center space-x-1 text-xs">
                                        <span class="bg-green-100 text-green-700 px-1.5 py-0.5 rounded font-bold">H:{{ $hadirCount }}</span>
                                        <span class="bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded font-bold">S:{{ $sakitCount }}</span>
                                        <span class="bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded font-bold">I:{{ $izinCount }}</span>
                                        <span class="bg-red-100 text-red-700 px-1.5 py-0.5 rounded font-bold">A:{{ $alfaCount }}</span>
                                    </div>
                                </div>

                                <!-- Search -->
                                <div class="relative mb-2">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <input type="text" x-model="search" placeholder="Cari nama santri..." class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-primary-500 focus:border-primary-500 bg-gray-50">
                                </div>

                                <!-- Student Table -->
                                <div class="border border-gray-200 rounded-lg overflow-hidden {{ $isOutsideTime ? 'opacity-60 pointer-events-none' : '' }}">
                                    <table class="w-full">
                                        <thead class="bg-gray-50 border-b border-gray-200">
                                            <tr>
                                                <th class="px-3 py-2 text-xs font-semibold text-gray-500 text-center w-10">#</th>
                                                <th class="px-3 py-2 text-xs font-semibold text-gray-500 text-left">Nama Santri</th>
                                                <th class="px-3 py-2 text-xs font-semibold text-gray-500 text-center w-36">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach($attendanceList as $index => $santri)
                                                <tr x-show="search === '' || '{{ strtolower(addslashes($santri['nama'])) }}'.includes(search.toLowerCase())" 
                                                    class="table-row hover:bg-gray-50 transition-colors {{ $santri['status'] !== 'H' ? 'bg-orange-50' : '' }}">
                                                    <td class="px-3 py-1.5 text-xs text-gray-400 text-center w-10">{{ $index + 1 }}</td>
                                                    <td class="px-3 py-1.5 text-sm text-gray-800">{{ $santri['nama'] }}</td>
                                                    <td class="px-3 py-1.5 text-center w-36">
                                                        <div class="inline-flex rounded-md overflow-hidden border border-gray-200 shadow-sm">
                                                            <button type="button" wire:click="toggleAttendance({{ $index }}, 'H')"
                                                                class="px-2 py-1 text-xs font-bold transition-all {{ $santri['status'] === 'H' ? 'bg-green-500 text-white' : 'bg-white text-gray-400 hover:bg-green-50 hover:text-green-600' }}">H</button>
                                                            <button type="button" wire:click="toggleAttendance({{ $index }}, 'S')"
                                                                class="px-2 py-1 text-xs font-bold border-l border-gray-200 transition-all {{ $santri['status'] === 'S' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-400 hover:bg-yellow-50 hover:text-yellow-600' }}">S</button>
                                                            <button type="button" wire:click="toggleAttendance({{ $index }}, 'I')"
                                                                class="px-2 py-1 text-xs font-bold border-l border-gray-200 transition-all {{ $santri['status'] === 'I' ? 'bg-blue-500 text-white' : 'bg-white text-gray-400 hover:bg-blue-50 hover:text-blue-600' }}">I</button>
                                                            <button type="button" wire:click="toggleAttendance({{ $index }}, 'A')"
                                                                class="px-2 py-1 text-xs font-bold border-l border-gray-200 transition-all {{ $santri['status'] === 'A' ? 'bg-red-500 text-white' : 'bg-white text-gray-400 hover:bg-red-50 hover:text-red-600' }}">A</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-center text-xs text-gray-400 mt-1.5">H = Hadir &bull; S = Sakit &bull; I = Izin &bull; A = Alfa</p>
                            </div>

                            <!-- Catatan -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Catatan <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                <textarea wire:model="journalForm.notes" rows="2" class="w-full rounded-lg border-gray-300 focus:ring-primary-500 focus:border-primary-500 text-sm {{ $isOutsideTime ? 'bg-gray-100 cursor-not-allowed' : '' }}" placeholder="Catatan tambahan jika ada..." {{ $isOutsideTime ? 'disabled' : '' }}></textarea>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-gray-50 px-5 py-3 border-t border-gray-200 flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                @if($isOutsideTime)
                                    <span class="text-amber-600 font-semibold">⚠ Tidak dapat menyimpan di luar jam 07.00 - 15.00</span>
                                @else
                                    <span class="font-semibold text-green-600">{{ $hadirCount }}</span> hadir, <span class="font-semibold text-red-600">{{ $sakitCount + $izinCount + $alfaCount }}</span> tidak hadir
                                @endif
                            </div>
                            <div class="flex space-x-2">
                                <button type="button" wire:click="closeJournalModal" class="px-3.5 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 font-medium text-sm transition-colors">
                                    {{ $isOutsideTime ? 'Tutup' : 'Batal' }}
                                </button>
                                @if(!$isOutsideTime)
                                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-medium text-sm transition-colors shadow-sm flex items-center space-x-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Simpan Jurnal</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
