<div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Presensi Guru</h1>
            <p class="text-gray-500">Input kehadiran guru harian</p>
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

    <!-- Date Picker -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="flex items-center space-x-4">
            <label class="text-sm font-medium text-gray-700">Tanggal:</label>
            <input type="date" wire:model.live="tanggal" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
        </div>
    </div>

    @if(count($attendances) > 0)
        <!-- Stats -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ $stats['hadir'] }}</p>
                <p class="text-xs text-green-600">Hadir</p>
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
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NIP</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Guru</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Jam Masuk</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Jam Pulang</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($attendances as $guruId => $att)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm font-mono text-gray-600">{{ $att['nip'] }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $att['nama'] }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="attendances.{{ $guruId }}.status" value="hadir" 
                                                   class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                            <span class="ml-1 text-xs text-green-600 font-medium">H</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="attendances.{{ $guruId }}.status" value="izin"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                            <span class="ml-1 text-xs text-blue-600 font-medium">I</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="attendances.{{ $guruId }}.status" value="sakit"
                                                   class="w-4 h-4 text-yellow-600 border-gray-300 focus:ring-yellow-500">
                                            <span class="ml-1 text-xs text-yellow-600 font-medium">S</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" wire:model="attendances.{{ $guruId }}.status" value="alpha"
                                                   class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                            <span class="ml-1 text-xs text-red-600 font-medium">A</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <input type="time" wire:model="attendances.{{ $guruId }}.jam_masuk" class="px-2 py-1 border border-gray-300 rounded text-sm">
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <input type="time" wire:model="attendances.{{ $guruId }}.jam_pulang" class="px-2 py-1 border border-gray-300 rounded text-sm">
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
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <h3 class="font-semibold text-gray-700 mb-2">Tidak ada data guru</h3>
        </div>
    @endif
</div>
