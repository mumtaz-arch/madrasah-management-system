<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Manajemen Nilai</h1>
            <p class="text-gray-500">Kelola nilai santri per mata pelajaran</p>
        </div>
        <a href="{{ route('admin.nilai.input') }}" 
           class="inline-flex items-center px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Input Nilai
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500">Total Nilai</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                    <span class="text-green-600 font-bold text-sm">UH</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['uh'] }}</p>
                    <p class="text-xs text-gray-500">Ulangan Harian</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <span class="text-yellow-600 font-bold text-sm">UTS</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['uts'] }}</p>
                    <p class="text-xs text-gray-500">UTS</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                    <span class="text-red-600 font-bold text-sm">UAS</span>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['uas'] }}</p>
                    <p class="text-xs text-gray-500">UAS</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <select wire:model.live="filterKelas" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="filterMapel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="filterSemester" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Semester</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                </select>
            </div>
            <div>
                <select wire:model.live="filterJenis" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Jenis</option>
                    <option value="UH">Ulangan Harian</option>
                    <option value="UTS">UTS</option>
                    <option value="UAS">UAS</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Santri</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mapel</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Guru</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($nilais as $nilai)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $nilai->santri->nama_lengkap }}</p>
                                    <p class="text-xs text-gray-500">{{ $nilai->santri->nis }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $nilai->mapel->nama }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $nilai->jenis === 'UH' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $nilai->jenis === 'UTS' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $nilai->jenis === 'UAS' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ $nilai->jenis }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-lg font-bold {{ $nilai->nilai >= $nilai->mapel->kkm ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($nilai->nilai, 0) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">Semester {{ $nilai->semester }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $nilai->guru->nama_lengkap ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-gray-500">Belum ada data nilai</p>
                                <a href="{{ route('admin.nilai.input') }}" class="mt-2 inline-flex items-center text-primary-600 hover:text-primary-700">
                                    Input nilai sekarang
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($nilais->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $nilais->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</div>
