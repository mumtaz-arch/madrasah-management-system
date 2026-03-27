<div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Presensi Santri</h1>
            <p class="text-gray-500">Input kehadiran santri per kelas</p>
        </div>
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

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas</label>
                <select wire:model.live="kelasId" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" wire:model.live="tanggal" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>
        </div>
    </div>

    @if($kelasId && count($attendances) > 0)
        <!-- Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-6">
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ $stats['hadir'] }}</p>
                <p class="text-xs text-green-600">Hadir</p>
            </div>
            <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-orange-600">{{ $stats['terlambat'] }}</p>
                <p class="text-xs text-orange-600">Terlambat</p>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $stats['izin'] }}</p>
                <p class="text-xs text-blue-600">Izin</p>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['sakit'] }}</p>
                <p class="text-xs text-yellow-600">Sakit</p>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-red-600">{{ $stats['alpha'] }}</p>
                <p class="text-xs text-red-600">Alpha</p>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NIS</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Santri</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Waktu Masuk</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Waktu Pulang</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($attendances as $santriId => $att)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm font-mono text-gray-600">{{ $att['nis'] }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $att['nama'] }}</td>
                                <td class="px-6 py-4">
                                    <input type="time" wire:model="attendances.{{ $santriId }}.waktu_masuk" class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                                </td>
                                <td class="px-6 py-4">
                                    <input type="time" wire:model="attendances.{{ $santriId }}.waktu_pulang" class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="attendances.{{ $santriId }}.status" value="hadir" 
                                                   class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                            <span class="ml-1 text-xs text-green-600 font-medium">H</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="attendances.{{ $santriId }}.status" value="terlambat" 
                                                   class="w-4 h-4 text-orange-600 border-gray-300 focus:ring-orange-500">
                                            <span class="ml-1 text-xs text-orange-600 font-medium">T</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="attendances.{{ $santriId }}.status" value="izin"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <span class="ml-1 text-xs text-blue-600 font-medium">I</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="attendances.{{ $santriId }}.status" value="sakit"
                                                   class="w-4 h-4 text-yellow-600 border-gray-300 focus:ring-yellow-500">
                                            <span class="ml-1 text-xs text-yellow-600 font-medium">S</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="attendances.{{ $santriId }}.status" value="alpha"
                                                   class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                            <span class="ml-1 text-xs text-red-600 font-medium">A</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Save Button -->
        <div class="mt-6 flex justify-end">
            <button wire:click="saveAttendances" class="btn-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Presensi
            </button>
        </div>
    @elseif($kelasId)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <h3 class="font-semibold text-gray-700 mb-2">Tidak ada santri di kelas ini</h3>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            <h3 class="font-semibold text-gray-700 mb-2">Pilih Kelas untuk Input Presensi</h3>
            <p class="text-gray-500">Pilih kelas dan tanggal terlebih dahulu</p>
        </div>
    @endif
</div>
