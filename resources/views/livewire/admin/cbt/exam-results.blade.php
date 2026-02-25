<div>
    @if($exam)
        {{-- Exam Detail View with Analytics --}}
        <div class="mb-6">
            <a href="{{ route('admin.cbt.results') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>

        <div class="mb-6">
            <h1 class="font-heading text-2xl font-bold text-gray-900">{{ $exam->title }}</h1>
            <p class="text-gray-500">{{ $exam->mapel->nama ?? '-' }} • {{ $exam->kelas->nama_kelas ?? '-' }}</p>
        </div>

        {{-- Analytics Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <p class="text-2xl font-bold text-gray-900">{{ $analytics['total_peserta'] }}</p>
                <p class="text-xs text-gray-500">Total Peserta</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $analytics['sudah_selesai'] }}</p>
                <p class="text-xs text-gray-500">Sudah Selesai</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <p class="text-2xl font-bold text-primary-600">{{ $analytics['rata_rata'] }}</p>
                <p class="text-xs text-gray-500">Rata-rata</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ $analytics['nilai_tertinggi'] }}</p>
                <p class="text-xs text-gray-500">Tertinggi</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <p class="text-2xl font-bold text-red-600">{{ $analytics['nilai_terendah'] }}</p>
                <p class="text-xs text-gray-500">Terendah</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ $analytics['lulus'] }}</p>
                <p class="text-xs text-gray-500">Lulus (≥70)</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 text-center">
                <p class="text-2xl font-bold text-red-600">{{ $analytics['tidak_lulus'] }}</p>
                <p class="text-xs text-gray-500">Tidak Lulus</p>
            </div>
        </div>

        {{-- Search --}}
        <div class="mb-4">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama santri..." 
                   class="w-full md:w-72 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
        </div>

        {{-- Results Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Peringkat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Santri</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Nilai</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Waktu Selesai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($results as $index => $result)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                @if($results->firstItem() + $index <= 3)
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                        {{ $results->firstItem() + $index === 1 ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $results->firstItem() + $index === 2 ? 'bg-gray-200 text-gray-700' : '' }}
                                        {{ $results->firstItem() + $index === 3 ? 'bg-orange-100 text-orange-700' : '' }}
                                        font-bold text-sm">
                                        {{ $results->firstItem() + $index }}
                                    </span>
                                @else
                                    <span class="text-gray-500">{{ $results->firstItem() + $index }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $result->santri->nama_lengkap ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xl font-bold {{ $result->nilai >= 70 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($result->nilai, 0) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $result->nilai >= 70 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $result->nilai >= 70 ? 'Lulus' : 'Tidak Lulus' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-500">
                                {{ $result->selesai?->format('d M Y, H:i') ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada hasil ujian</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($results && $results->hasPages())<div class="px-6 py-4 border-t">{{ $results->links('vendor.pagination.tailwind') }}</div>@endif
        </div>

    @else
        {{-- Exam List View --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="font-heading text-2xl font-bold text-gray-900">Hasil Ujian CBT</h1>
                <p class="text-gray-500">Lihat analisis dan hasil ujian</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Ujian</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mapel</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Peserta</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($exams as $exam)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $exam->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $exam->mapel->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $exam->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                    {{ $exam->completed_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $exam->status_badge }}">
                                    {{ ucfirst($exam->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.cbt.results', ['examId' => $exam->id]) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700 transition-colors">
                                    Lihat Hasil
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada ujian</td></tr>
                    @endforelse
                </tbody>
            </table>
            @if($exams && $exams->hasPages())<div class="px-6 py-4 border-t">{{ $exams->links('vendor.pagination.tailwind') }}</div>@endif
        </div>
    @endif
</div>
