<x-layouts.admin>
    <x-slot:title>Detail Nilai - {{ $santri->nama_lengkap }}</x-slot:title>
    <x-slot:header>Detail Nilai</x-slot:header>
    
    <div>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="font-heading text-2xl font-bold text-gray-900">{{ $santri->nama_lengkap }}</h1>
                <p class="text-gray-500">NIS: {{ $santri->nis }} | Kelas: {{ $santri->kelas->nama_kelas ?? '-' }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.rapor.preview', $santri) }}" target="_blank" class="btn-secondary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Preview PDF
                </a>
                <a href="{{ route('admin.rapor.download', $santri) }}" class="btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Tugas</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">UTS</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">UAS</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Rata-rata</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php $totalAvg = 0; $count = 0; @endphp
                        @foreach($nilais as $mapelId => $mapelNilais)
                            @foreach($mapelNilais as $nilai)
                                @php
                                    $avg = ($nilai->nilai_tugas + $nilai->nilai_uts + $nilai->nilai_uas) / 3;
                                    $totalAvg += $avg;
                                    $count++;
                                    $predikat = match(true) {
                                        $avg >= 90 => 'A',
                                        $avg >= 80 => 'B',
                                        $avg >= 70 => 'C',
                                        $avg >= 60 => 'D',
                                        default => 'E',
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $loop->parent->iteration }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $nilai->mapel->nama ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">{{ $nilai->nilai_tugas }}</td>
                                    <td class="px-6 py-4 text-center">{{ $nilai->nilai_uts }}</td>
                                    <td class="px-6 py-4 text-center">{{ $nilai->nilai_uas }}</td>
                                    <td class="px-6 py-4 text-center font-semibold">{{ number_format($avg, 1) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                            {{ $predikat == 'A' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $predikat == 'B' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $predikat == 'C' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            {{ in_array($predikat, ['D', 'E']) ? 'bg-red-100 text-red-700' : '' }}">
                                            {{ $predikat }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-right font-semibold text-gray-700">Rata-rata Keseluruhan:</td>
                            <td class="px-6 py-4 text-center font-bold text-lg text-primary-600">
                                {{ $count > 0 ? number_format($totalAvg / $count, 2) : '-' }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.rapor.index') }}" class="text-primary-600 hover:text-primary-700">
                &larr; Kembali ke daftar
            </a>
        </div>
    </div>
</x-layouts.admin>
