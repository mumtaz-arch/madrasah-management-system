<div>
    <div class="mb-8">
        <h1 class="font-heading text-2xl font-bold text-gray-900">Ujian Online (CBT)</h1>
        <p class="text-gray-500">Daftar ujian yang tersedia dan riwayat ujian</p>
    </div>

    {{-- Available Exams --}}
    <div class="mb-8">
        <h2 class="font-semibold text-lg text-gray-800 mb-4">Ujian Tersedia</h2>
        
        @if($availableExams->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($availableExams as $exam)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-3">
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Aktif</span>
                                <span class="text-sm text-gray-500">{{ $exam->durasi_menit }} menit</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">{{ $exam->title }}</h3>
                            <p class="text-sm text-gray-500 mb-4">{{ $exam->mapel->nama ?? '-' }}</p>
                            
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Berakhir: {{ $exam->selesai->format('d M Y, H:i') }}
                            </div>
                            
                            <a href="{{ route('santri.cbt.take', $exam) }}" 
                               class="block w-full text-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-medium transition-colors">
                                Mulai Ujian
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-gray-500">Tidak ada ujian yang tersedia saat ini</p>
            </div>
        @endif
    </div>

    {{-- Completed Exams --}}
    <div>
        <h2 class="font-semibold text-lg text-gray-800 mb-4">Riwayat Ujian</h2>
        
        @if($completedExams->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Ujian</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mapel</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Nilai</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Waktu Selesai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($completedExams as $attempt)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $attempt->exam->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $attempt->exam->mapel->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                        {{ $attempt->nilai >= 70 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ number_format($attempt->nilai, 0) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-gray-500">{{ $attempt->selesai->format('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white rounded-xl border border-gray-200 p-8 text-center">
                <p class="text-gray-500">Belum ada riwayat ujian</p>
            </div>
        @endif
    </div>
</div>
