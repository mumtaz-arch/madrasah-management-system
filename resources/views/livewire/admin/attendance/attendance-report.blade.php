<div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Laporan Presensi</h1>
            <p class="text-gray-500">Rekap kehadiran santri dan guru</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                <select wire:model.live="filterType" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="santri">Santri</option>
                    <option value="guru">Guru</option>
                </select>
            </div>
            @if($filterType === 'santri')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select wire:model="kelasId" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari</label>
                <input type="date" wire:model="startDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai</label>
                <input type="date" wire:model="endDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex items-end">
                <button wire:click="generateReport" class="w-full btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Generate
                </button>
            </div>
        </div>
    </div>

    <!-- Report Table -->
    @if(count($reportData) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">{{ $filterType === 'santri' ? 'NIS' : 'NIP' }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                            @if($filterType === 'santri')
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                            @endif
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">H</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">I</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">S</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">A</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">%</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($reportData as $index => $data)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm font-mono text-gray-600">{{ $data['nis'] }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $data['nama'] }}</td>
                                @if($filterType === 'santri')
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $data['kelas'] }}</td>
                                @endif
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">{{ $data['stats']['hadir'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">{{ $data['stats']['izin'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">{{ $data['stats']['sakit'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">{{ $data['stats']['alpha'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-center font-semibold {{ $data['persentase'] >= 80 ? 'text-green-600' : ($data['persentase'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $data['persentase'] }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="font-semibold text-gray-700 mb-2">Belum ada data</h3>
            <p class="text-gray-500">Pilih filter dan klik Generate untuk melihat laporan</p>
        </div>
    @endif
</div>
