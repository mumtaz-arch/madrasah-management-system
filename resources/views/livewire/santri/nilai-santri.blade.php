<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900 mb-1">Nilai Saya</h1>
            <p class="text-gray-500">Semester {{ $semester }} - {{ $santri->kelas->nama_kelas ?? 'Kelas tidak ditemukan' }}</p>
        </div>
        <div class="text-right">
            <p class="text-3xl font-bold text-primary-600">{{ $rataRata }}</p>
            <p class="text-sm text-gray-500">Rata-rata</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <select wire:model.live="semester" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            <option value="1">Semester 1</option>
            <option value="2">Semester 2</option>
        </select>
    </div>

    @if($nilais->count() > 0)
        <div class="space-y-4">
            @foreach($nilais as $mapelId => $mapelNilais)
                @php
                    $mapel = $mapelNilais->first()->mapel;
                    $avgNilai = $mapelNilais->avg('nilai');
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex px-2 py-1 text-xs font-mono rounded bg-primary-100 text-primary-700">{{ $mapel->kode }}</span>
                            <span class="font-semibold text-gray-900">{{ $mapel->nama }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-bold {{ $avgNilai >= $mapel->kkm ? 'text-green-600' : 'text-red-600' }}">
                                {{ round($avgNilai, 1) }}
                            </span>
                            <span class="text-xs text-gray-500 ml-1">(KKM: {{ $mapel->kkm }})</span>
                        </div>
                    </div>
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-3 gap-4">
                            @php
                                $uh = $mapelNilais->where('jenis', 'UH')->first();
                                $uts = $mapelNilais->where('jenis', 'UTS')->first();
                                $uas = $mapelNilais->where('jenis', 'UAS')->first();
                            @endphp
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">UH</p>
                                <p class="text-xl font-bold {{ ($uh && $uh->nilai >= $mapel->kkm) ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $uh ? number_format($uh->nilai, 0) : '-' }}
                                </p>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">UTS</p>
                                <p class="text-xl font-bold {{ ($uts && $uts->nilai >= $mapel->kkm) ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $uts ? number_format($uts->nilai, 0) : '-' }}
                                </p>
                            </div>
                            <div class="text-center p-3 bg-gray-50 rounded-lg">
                                <p class="text-xs text-gray-500 mb-1">UAS</p>
                                <p class="text-xl font-bold {{ ($uas && $uas->nilai >= $mapel->kkm) ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $uas ? number_format($uas->nilai, 0) : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-500">Belum ada nilai untuk semester ini</p>
        </div>
    @endif
</div>
