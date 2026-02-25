<div>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Detail Pendaftaran</h1>
            <p class="text-gray-500">No. Registrasi: {{ $registration->no_registrasi }}</p>
        </div>
        <a href="{{ route('admin.ppdb.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Pribadi -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-heading font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Data Pribadi
                </h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Nama Lengkap</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->nama_lengkap }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">TTL</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->tempat_lahir }}, {{ $registration->tanggal_lahir->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Jenis Kelamin</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">No. HP</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->no_hp }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Email</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->email }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-sm text-gray-500">Alamat</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->alamat }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Data Orang Tua -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-heading font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Data Orang Tua
                </h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Nama Ayah</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->nama_ayah }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Pekerjaan</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->pekerjaan_ayah ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Nama Ibu</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->nama_ibu }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Pekerjaan</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->pekerjaan_ibu ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">No. HP Orang Tua</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->no_hp_ortu }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Data Pendidikan -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-heading font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Data Pendidikan
                </h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Asal Sekolah</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->asal_sekolah }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Tahun Lulus</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->tahun_lulus }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">NISN</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->nisn ?: '-' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Dokumen Upload -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" x-data="{ showModal: false, modalImage: '', modalTitle: '' }">
                <h3 class="font-heading font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Dokumen yang Diupload ({{ $registration->documents->count() }} file)
                </h3>
                
                @php
                    $docTypes = [
                        'Kartu Keluarga' => ['color' => 'blue', 'icon' => 'users'],
                        'Akta Kelahiran' => ['color' => 'purple', 'icon' => 'document'],
                        'Ijazah/SKL' => ['color' => 'amber', 'icon' => 'academic'],
                        'KTP Orang Tua' => ['color' => 'teal', 'icon' => 'id'],
                        'Pas Foto' => ['color' => 'emerald', 'icon' => 'camera'],
                    ];
                @endphp

                @if($registration->documents->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach($registration->documents as $doc)
                            @php
                                $colorClass = $docTypes[$doc->jenis_dokumen]['color'] ?? 'gray';
                                $extension = pathinfo($doc->file_path, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp
                            <div class="text-center">
                                <div class="bg-{{ $colorClass }}-50 rounded-xl p-3 border border-{{ $colorClass }}-100 mb-2 aspect-square flex items-center justify-center overflow-hidden">
                                    @if($isImage)
                                        <img src="{{ asset('storage/' . $doc->file_path) }}" 
                                             alt="{{ $doc->jenis_dokumen }}" 
                                             class="max-w-full max-h-full object-contain rounded-lg cursor-pointer hover:opacity-80 hover:scale-105 transition-all duration-200" 
                                             @click="showModal = true; modalImage = '{{ asset('storage/' . $doc->file_path) }}'; modalTitle = '{{ $doc->jenis_dokumen }}'">
                                    @else
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-{{ $colorClass }}-600 hover:text-{{ $colorClass }}-800 flex flex-col items-center">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-xs mt-1 uppercase">{{ $extension }}</span>
                                        </a>
                                    @endif
                                </div>
                                <p class="text-xs font-medium text-gray-700">{{ $doc->jenis_dokumen }}</p>
                                <p class="text-xs text-green-600">✓ Uploaded</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-500">Klik pada gambar untuk preview, atau icon PDF untuk download</p>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm">Belum ada dokumen yang diupload</p>
                        <p class="text-xs mt-1">Pendaftar belum melengkapi dokumen persyaratan</p>
                    </div>
                @endif

                <!-- Image Preview Modal -->
                <div x-show="showModal" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70"
                     @click.self="showModal = false"
                     @keydown.escape.window="showModal = false">
                    
                    <div x-show="showModal"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-90"
                         class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
                        
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50">
                            <h3 class="font-heading font-semibold text-gray-900" x-text="modalTitle"></h3>
                            <div class="flex items-center space-x-2">
                                <a :href="modalImage" target="_blank" 
                                   class="p-2 text-gray-500 hover:text-primary-600 hover:bg-gray-100 rounded-lg transition-colors"
                                   title="Buka di tab baru">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                                <a :href="modalImage" download 
                                   class="p-2 text-gray-500 hover:text-green-600 hover:bg-gray-100 rounded-lg transition-colors"
                                   title="Download">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>
                                <button @click="showModal = false" 
                                        class="p-2 text-gray-500 hover:text-red-600 hover:bg-gray-100 rounded-lg transition-colors"
                                        title="Tutup">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Modal Body -->
                        <div class="p-6 flex items-center justify-center bg-gray-100" style="max-height: calc(90vh - 80px);">
                            <img :src="modalImage" 
                                 :alt="modalTitle" 
                                 class="max-w-full max-h-[70vh] object-contain rounded-lg shadow-lg">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="font-heading font-semibold text-gray-900 mb-4">Status Pendaftaran</h3>
                
                <div class="text-center mb-6">
                    <span class="inline-flex px-4 py-2 text-lg font-semibold rounded-full
                        {{ $registration->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $registration->status === 'verified' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $registration->status === 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $registration->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}">
                        {{ ucfirst($registration->status) }}
                    </span>
                </div>
                
                <div class="space-y-2">
                    @if($registration->status === 'pending')
                        <button wire:click="updateStatus('verified')" class="w-full px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            Verifikasi Data
                        </button>
                        <button wire:click="updateStatus('rejected')" class="w-full px-4 py-2 border border-red-300 text-red-600 font-semibold rounded-lg hover:bg-red-50 transition-colors">
                            Tolak Pendaftaran
                        </button>
                    @endif
                    
                    @if($registration->status === 'verified')
                        <button wire:click="convertToSantri" 
                                wire:confirm="Pendaftar akan dikonversi menjadi santri aktif. Lanjutkan?"
                                class="w-full px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                            Terima & Jadikan Santri
                        </button>
                        <button wire:click="updateStatus('rejected')" class="w-full px-4 py-2 border border-red-300 text-red-600 font-semibold rounded-lg hover:bg-red-50 transition-colors">
                            Tolak Pendaftaran
                        </button>
                    @endif
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                <h3 class="font-heading font-semibold text-gray-900 mb-4">Informasi</h3>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500">Tanggal Daftar</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Tahun Ajaran</dt>
                        <dd class="font-medium text-gray-900">{{ $registration->tahun_ajaran }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
