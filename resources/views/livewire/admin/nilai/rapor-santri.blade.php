<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Rapor Santri</h1>
            <p class="text-gray-500">{{ $santri->nama_lengkap }} - {{ $santri->kelas->nama_kelas ?? 'Belum ada kelas' }}</p>
        </div>
        <a href="{{ route('admin.santri.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Santri Info Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-xl">
                {{ strtoupper(substr($santri->nama_lengkap, 0, 2)) }}
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900">{{ $santri->nama_lengkap }}</h2>
                <p class="text-gray-500">NIS: {{ $santri->nis }} | NISN: {{ $santri->nisn ?? '-' }}</p>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-primary-600">{{ $rataRata }}</p>
                <p class="text-sm text-gray-500">Rata-rata</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select wire:model.live="semester" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                <input type="text" wire:model.live="tahun_ajaran" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="2024/2025">
            </div>
        </div>
    </div>

    <!-- Rapor Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="font-heading font-semibold text-gray-900">Daftar Nilai Semester {{ $semester }}</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">KKM</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">UH</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">UTS</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">UAS</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai Akhir</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($raporData as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex px-2 py-1 text-xs font-mono rounded bg-gray-100 text-gray-600">{{ $item['mapel']->kode }}</span>
                                    <span class="font-medium text-gray-900">{{ $item['mapel']->nama }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $item['kkm'] }}</td>
                            <td class="px-6 py-4 text-center text-sm {{ $item['uh'] && $item['uh'] >= $item['kkm'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $item['uh'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm {{ $item['uts'] && $item['uts'] >= $item['kkm'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $item['uts'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm {{ $item['uas'] && $item['uas'] >= $item['kkm'] ? 'text-green-600' : 'text-red-600' }}">
                                {{ $item['uas'] ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-lg font-bold {{ $item['nilai_akhir'] >= $item['kkm'] ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $item['nilai_akhir'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $item['status'] === 'Tuntas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-500">Belum ada nilai untuk semester ini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($raporData) > 0)
                    <tfoot class="bg-gray-50 border-t border-gray-200">
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-right font-semibold text-gray-700">Rata-rata Nilai Akhir:</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xl font-bold text-primary-600">{{ $rataRata }}</span>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
