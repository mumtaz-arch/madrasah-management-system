<x-layouts.admin title="Detail Jurnal">
<div class="max-w-4xl mx-auto space-y-8">
    <div>
        <a href="{{ route('admin.journal.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-600 to-primary-700 px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-white">Detail Jurnal Mengajar</h2>
                    <p class="text-primary-100 text-sm mt-1">{{ $journal->date->translatedFormat('l, d F Y') }}</p>
                </div>
                <span class="px-3 py-1.5 rounded-full text-sm font-semibold {{ $journal->status_badge }}">
                    {{ $journal->status_label }}
                </span>
            </div>
        </div>

        <!-- Guru & Jadwal Info -->
        <div class="px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Guru</p>
                        <p class="font-semibold text-gray-900 mt-1">{{ $journal->teacher->nama_lengkap ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Kelas</p>
                        <p class="font-semibold text-gray-900 mt-1">{{ $journal->classroom->nama_kelas ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Mata Pelajaran</p>
                        <p class="font-semibold text-gray-900 mt-1">{{ $journal->subject->nama ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Waktu Jadwal vs Waktu Pengisian -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100">
            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Informasi Waktu</h4>
        </div>
        <div class="px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 rounded-xl p-5 border border-blue-100">
                    <div class="flex items-center space-x-2 mb-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-semibold text-blue-800">Jadwal Mengajar</span>
                    </div>
                    @if($journal->jadwal)
                        <p class="text-3xl font-bold text-blue-900">
                            {{ \Carbon\Carbon::parse($journal->jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($journal->jadwal->jam_selesai)->format('H:i') }}
                        </p>
                        <p class="text-sm text-blue-600 mt-2">{{ ucfirst($journal->jadwal->hari) }}</p>
                    @else
                        <p class="text-lg font-bold text-blue-900">-</p>
                        <p class="text-sm text-blue-600 mt-2">Tidak terkait jadwal</p>
                    @endif
                </div>
                <div class="bg-emerald-50 rounded-xl p-5 border border-emerald-100">
                    <div class="flex items-center space-x-2 mb-3">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-semibold text-emerald-800">Waktu Pengisian (Realtime)</span>
                    </div>
                    @if($journal->submitted_at)
                        <p class="text-3xl font-bold text-emerald-900">{{ $journal->submitted_at->format('H:i:s') }}</p>
                        <p class="text-sm text-emerald-600 mt-2">{{ $journal->submitted_at->translatedFormat('d F Y') }}</p>
                    @else
                        <p class="text-lg font-bold text-emerald-900">-</p>
                        <p class="text-sm text-emerald-600 mt-2">Belum tersedia</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Pembelajaran -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100">
            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Detail Pembelajaran</h4>
        </div>
        <div class="px-8 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-medium mb-2">Materi Pembelajaran</p>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <p class="text-gray-900 font-medium">{{ $journal->topic }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-medium mb-2">Metode Pembelajaran</p>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <p class="text-gray-900 font-medium">{{ $journal->method }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kehadiran Siswa -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100">
            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Kehadiran Siswa</h4>
        </div>
        <div class="px-8 py-6 space-y-6">
            @php
                $details = $journal->attendance_details ?? [];
                $sakitList = collect($details)->where('status', 'S')->values();
                $izinList = collect($details)->where('status', 'I')->values();
                $alfaList = collect($details)->where('status', 'A')->values();
                $totalAbsent = $sakitList->count() + $izinList->count() + $alfaList->count();
            @endphp

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-green-50 rounded-xl p-4 text-center border border-green-100">
                    <p class="text-3xl font-bold text-green-600">{{ $journal->present_count }}</p>
                    <p class="text-sm text-green-700 font-medium mt-1">Hadir</p>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4 text-center border border-yellow-100">
                    <p class="text-3xl font-bold text-yellow-600">{{ $sakitList->count() }}</p>
                    <p class="text-sm text-yellow-700 font-medium mt-1">Sakit</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4 text-center border border-blue-100">
                    <p class="text-3xl font-bold text-blue-600">{{ $izinList->count() }}</p>
                    <p class="text-sm text-blue-700 font-medium mt-1">Izin</p>
                </div>
                <div class="bg-red-50 rounded-xl p-4 text-center border border-red-100">
                    <p class="text-3xl font-bold text-red-600">{{ $alfaList->count() }}</p>
                    <p class="text-sm text-red-700 font-medium mt-1">Alfa</p>
                </div>
            </div>

            <!-- Detail Siswa Tidak Hadir -->
            @if($totalAbsent > 0)
                <div class="border border-orange-200 rounded-xl bg-orange-50/50 overflow-hidden">
                    <div class="px-5 py-3 bg-orange-100/60 border-b border-orange-200">
                        <h5 class="text-sm font-semibold text-orange-800 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            Siswa Tidak Hadir ({{ $totalAbsent }} orang)
                        </h5>
                    </div>
                    <div class="px-5 py-4 space-y-4">
                        @if($sakitList->count() > 0)
                            <div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-yellow-200 text-yellow-800 mb-2">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                    SAKIT ({{ $sakitList->count() }})
                                </span>
                                <div class="ml-1 space-y-1.5">
                                    @foreach($sakitList as $i => $s)
                                        <div class="flex items-center text-sm text-gray-700">
                                            <span class="w-5 text-xs text-gray-400 mr-2">{{ $i + 1 }}.</span>
                                            <span class="w-2 h-2 rounded-full bg-yellow-400 mr-2 flex-shrink-0"></span>
                                            {{ $s['nama'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($izinList->count() > 0)
                            <div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-200 text-blue-800 mb-2">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    IZIN ({{ $izinList->count() }})
                                </span>
                                <div class="ml-1 space-y-1.5">
                                    @foreach($izinList as $i => $s)
                                        <div class="flex items-center text-sm text-gray-700">
                                            <span class="w-5 text-xs text-gray-400 mr-2">{{ $i + 1 }}.</span>
                                            <span class="w-2 h-2 rounded-full bg-blue-400 mr-2 flex-shrink-0"></span>
                                            {{ $s['nama'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($alfaList->count() > 0)
                            <div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-red-200 text-red-800 mb-2">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    ALFA ({{ $alfaList->count() }})
                                </span>
                                <div class="ml-1 space-y-1.5">
                                    @foreach($alfaList as $i => $s)
                                        <div class="flex items-center text-sm text-gray-700">
                                            <span class="w-5 text-xs text-gray-400 mr-2">{{ $i + 1 }}.</span>
                                            <span class="w-2 h-2 rounded-full bg-red-400 mr-2 flex-shrink-0"></span>
                                            {{ $s['nama'] }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                @if(count($details) > 0)
                    <div class="text-center py-3 bg-green-50 rounded-lg border border-green-100">
                        <p class="text-sm text-green-700 font-medium flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Semua siswa hadir
                        </p>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Catatan -->
    @if($journal->notes)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100">
            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Catatan Tambahan</h4>
        </div>
        <div class="px-8 py-6">
            <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-100">
                <p class="text-gray-800 leading-relaxed">{{ $journal->notes }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Verifikasi -->
    @if($journal->status === 'verified')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100">
            <h4 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Informasi Verifikasi</h4>
        </div>
        <div class="px-8 py-6">
            <div class="flex items-center space-x-4 bg-green-50 rounded-xl p-5 border border-green-100">
                <div class="w-12 h-12 rounded-full bg-green-200 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-green-900 text-base">{{ $journal->verifier->name ?? '-' }}</p>
                    <p class="text-sm text-green-700 mt-0.5">{{ $journal->verified_at->translatedFormat('d F Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Action -->
    @if($journal->status === 'sent')
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <h4 class="text-lg font-semibold text-gray-900 mb-2">Verifikasi Jurnal</h4>
        <p class="text-gray-500 text-sm mb-5">Pastikan data jurnal sudah benar sebelum memverifikasi.</p>
        <form action="{{ route('admin.journal.verify', $journal) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="inline-flex items-center px-5 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Verifikasi Jurnal Ini
            </button>
        </form>
    </div>
    @endif
</div>
</x-layouts.admin>
