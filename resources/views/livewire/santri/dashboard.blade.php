<div>
    @if($santri)
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl shadow-lg p-6 mb-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-primary-100 text-sm">Assalamu'alaikum,</p>
                    <h1 class="font-heading text-2xl font-bold">{{ $santri->nama_lengkap }}</h1>
                    <p class="text-primary-200 text-sm mt-1">NIS: {{ $santri->nis }} | {{ $santri->kelas->nama_kelas ?? 'Belum ada kelas' }}</p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- CBT Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="font-heading font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Ujian Aktif
                </h3>
            </div>
            <div class="p-6">
                @if(isset($activeExams) && $activeExams->count() > 0)
                    <div class="grid gap-4">
                        @foreach($activeExams as $exam)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-primary-300 transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $exam->title }}</h4>
                                    <p class="text-sm text-gray-500">{{ $exam->mapel->nama ?? '-' }} • {{ $exam->duration }} menit</p>
                                </div>
                                <a href="{{ route('santri.cbt.take', $exam->id) }}" 
                                   class="px-4 py-2 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                                    Mulai Ujian
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-gray-500 py-8">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p>Tidak ada ujian aktif saat ini</p>
                        <p class="text-sm mt-1">Ujian akan muncul di sini saat tersedia</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-blue-900">Informasi Penting</h4>
                    <p class="text-blue-700 text-sm mt-1">
                        Portal ini hanya untuk mengerjakan ujian (CBT). Untuk melihat nilai, jadwal, dan informasi lainnya, 
                        silakan hubungi Wali Anda atau tanyakan langsung ke Ustadz/Ustadzah.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
            <svg class="w-12 h-12 mx-auto text-yellow-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <h3 class="font-semibold text-yellow-800 mb-2">Data Santri Tidak Ditemukan</h3>
            <p class="text-yellow-600">Akun Anda belum terhubung dengan data santri. Silakan hubungi admin.</p>
        </div>
    @endif
</div>
