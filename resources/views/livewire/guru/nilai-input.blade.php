<div>
    <!-- Header -->
    <div class="mb-6">
        <h1 class="font-heading text-2xl font-bold text-gray-900">Input Nilai</h1>
        <p class="text-gray-500">Masukkan nilai untuk mata pelajaran yang Anda ampu</p>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Mapel Select -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                <select wire:model.live="selectedMapelId" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Pilih Mapel</option>
                    @foreach($mapelList as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Kelas Select -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select wire:model.live="selectedKelasId" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" {{ !$selectedMapelId ? 'disabled' : '' }}>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Semester -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select wire:model.live="semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                </select>
            </div>
            
            <!-- Tahun Ajaran -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                <input type="text" wire:model.live="tahunAjaran" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="2024/2025">
            </div>
        </div>
    </div>

    <!-- Nilai Input Table -->
    @if($selectedMapelId && $selectedKelasId && count($nilaiData) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">Daftar Nilai Santri</h3>
                    <p class="text-sm text-gray-500">{{ count($nilaiData) }} santri</p>
                </div>
                <button wire:click="saveNilai" class="px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Nilai
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Santri</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Tugas</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">UTS</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">UAS</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($nilaiData as $santriId => $data)
                            @php
                                $avg = null;
                                $count = 0;
                                $sum = 0;
                                if ($data['tugas']) { $sum += $data['tugas']; $count++; }
                                if ($data['uts']) { $sum += $data['uts']; $count++; }
                                if ($data['uas']) { $sum += $data['uas']; $count++; }
                                if ($count > 0) { $avg = round($sum / $count, 1); }
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $data['nis'] }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-semibold text-sm">
                                            {{ strtoupper(substr($data['nama'], 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $data['nama'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="number" 
                                           wire:model.blur="nilaiData.{{ $santriId }}.tugas"
                                           min="0" max="100"
                                           class="w-20 px-3 py-2 text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="-">
                                </td>
                                <td class="px-6 py-4">
                                    <input type="number" 
                                           wire:model.blur="nilaiData.{{ $santriId }}.uts"
                                           min="0" max="100"
                                           class="w-20 px-3 py-2 text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="-">
                                </td>
                                <td class="px-6 py-4">
                                    <input type="number" 
                                           wire:model.blur="nilaiData.{{ $santriId }}.uas"
                                           min="0" max="100"
                                           class="w-20 px-3 py-2 text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                           placeholder="-">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($avg !== null)
                                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                            {{ $avg >= 75 ? 'bg-green-100 text-green-700' : ($avg >= 60 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                            {{ $avg }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($selectedMapelId && $selectedKelasId)
        <!-- No Students -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak Ada Santri</h3>
            <p class="text-gray-500">Tidak ada santri aktif di kelas ini.</p>
        </div>
    @else
        <!-- Select Prompt -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Pilih Mata Pelajaran & Kelas</h3>
            <p class="text-gray-500">Silakan pilih mata pelajaran dan kelas untuk mulai input nilai.</p>
        </div>
    @endif
</div>
